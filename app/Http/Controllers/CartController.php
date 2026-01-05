<?php

namespace App\Http\Controllers;

use App\Jobs\LowStockNotification;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index(): Response
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return Inertia::render('Cart/Index', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if enough stock is available
        if ($product->stock_quantity < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available.');
        }

        // Check if item already exists in cart
        $cartItem = auth()->user()->cartItems()
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            // Update quantity if item exists
            $newQuantity = $cartItem->quantity + $validated['quantity'];

            if ($product->stock_quantity < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            auth()->user()->cartItems()->create($validated);
        }

        return back()->with('success', 'Product added to cart!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if enough stock is available
        if ($cartItem->product->stock_quantity < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartItem->update($validated);

        return back()->with('success', 'Cart updated!');
    }

    /**
     * Remove a cart item.
     */
    public function destroy(CartItem $cartItem): RedirectResponse
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    /**
     * Process checkout (simplified version).
     */
    public function checkout(Request $request): RedirectResponse
    {
        $cartItems = $request->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Calculate order total and items count
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        $itemsCount = $cartItems->sum('quantity');

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;

            // Check stock availability
            if ($product->stock_quantity < $cartItem->quantity) {
                return back()->with('error', "Not enough stock for {$product->name}.");
            }

            // Reduce stock
            $newStock = $product->stock_quantity - $cartItem->quantity;
            $product->update(['stock_quantity' => $newStock]);

            // Dispatch low stock notification if needed
            if ($product->fresh()->isLowStock()) {
                LowStockNotification::dispatch($product);
            }

            // Remove item from cart
            $cartItem->delete();
        }

        // Save order record
        Order::create([
            'user_id' => $request->user()->id,
            'total' => $total,
            'items_count' => $itemsCount,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Order placed successfully!');
    }
}
