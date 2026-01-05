import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/react';
import { Minus, Plus, ShoppingCart, Trash2 } from 'lucide-react';
import { useState } from 'react';

interface Product {
    id: number;
    name: string;
    description: string | null;
    price: number;
    stock_quantity: number;
    image_url: string | null;
}

interface CartItem {
    id: number;
    product_id: number;
    quantity: number;
    product: Product;
}

interface Props {
    cartItems: CartItem[];
    total: number;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Shopping Cart',
        href: '/cart',
    },
];

export default function CartIndex() {
    const { cartItems, total } = usePage<Props>().props;
    const [updatingItem, setUpdatingItem] = useState<number | null>(null);
    const [removingItem, setRemovingItem] = useState<number | null>(null);
    const [processingCheckout, setProcessingCheckout] = useState(false);

    const updateQuantity = (cartItemId: number, newQuantity: number) => {
        if (newQuantity < 1) return;

        setUpdatingItem(cartItemId);
        router.put(
            `/cart/${cartItemId}`,
            {
                quantity: newQuantity,
            },
            {
                preserveScroll: true,
                onFinish: () => setUpdatingItem(null),
            }
        );
    };

    const removeItem = (cartItemId: number) => {
        setRemovingItem(cartItemId);
        router.delete(`/cart/${cartItemId}`, {
            preserveScroll: true,
            onFinish: () => setRemovingItem(null),
        });
    };

    const handleCheckout = () => {
        setProcessingCheckout(true);
        router.post('/cart/checkout', {}, {
            onFinish: () => setProcessingCheckout(false),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Shopping Cart" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                <div className="flex items-center justify-between">
                    <h1 className="text-3xl font-bold">Shopping Cart</h1>
                </div>

                {cartItems.length === 0 ? (
                    <div className="flex flex-col items-center justify-center rounded-xl border border-dashed border-sidebar-border py-12">
                        <ShoppingCart className="mb-4 size-16 text-muted-foreground" />
                        <h2 className="text-xl font-semibold">Your cart is empty</h2>
                        <p className="mb-4 text-muted-foreground">Add some products to get started.</p>
                        <Button onClick={() => router.get('/products')}>Browse Products</Button>
                    </div>
                ) : (
                    <div className="grid gap-6 lg:grid-cols-3">
                        <div className="lg:col-span-2">
                            <div className="space-y-4">
                                {cartItems.map((item) => (
                                    <div
                                        key={item.id}
                                        className="flex gap-4 rounded-lg border border-sidebar-border bg-card p-4"
                                    >
                                        <div className="size-24 flex-shrink-0 overflow-hidden rounded-md bg-muted">
                                            {item.product.image_url ? (
                                                <img
                                                    src={item.product.image_url}
                                                    alt={item.product.name}
                                                    className="size-full object-cover"
                                                />
                                            ) : (
                                                <div className="flex size-full items-center justify-center">
                                                    <ShoppingCart className="size-8 text-muted-foreground" />
                                                </div>
                                            )}
                                        </div>
                                        <div className="flex flex-1 flex-col justify-between">
                                            <div>
                                                <h3 className="font-semibold">{item.product.name}</h3>
                                                <p className="text-sm text-muted-foreground">
                                                    ${Number(item.product.price).toFixed(2)} each
                                                </p>
                                                <p className="text-xs text-muted-foreground">
                                                    {item.product.stock_quantity} available
                                                </p>
                                            </div>
                                            <div className="flex items-center gap-2">
                                                <div className="flex items-center gap-1">
                                                    <Button
                                                        variant="outline"
                                                        size="icon"
                                                        className="size-8"
                                                        onClick={() => updateQuantity(item.id, item.quantity - 1)}
                                                        disabled={item.quantity <= 1 || updatingItem === item.id}
                                                    >
                                                        <Minus className="size-3" />
                                                    </Button>
                                                    <Input
                                                        type="number"
                                                        min="1"
                                                        max={item.product.stock_quantity}
                                                        value={item.quantity}
                                                        onChange={(e) =>
                                                            updateQuantity(item.id, parseInt(e.target.value))
                                                        }
                                                        className="w-16 text-center"
                                                        disabled={updatingItem === item.id}
                                                    />
                                                    <Button
                                                        variant="outline"
                                                        size="icon"
                                                        className="size-8"
                                                        onClick={() => updateQuantity(item.id, item.quantity + 1)}
                                                        disabled={
                                                            item.quantity >= item.product.stock_quantity ||
                                                            updatingItem === item.id
                                                        }
                                                    >
                                                        <Plus className="size-3" />
                                                    </Button>
                                                </div>
                                                <Button
                                                    variant="ghost"
                                                    size="icon"
                                                    className="size-8 text-destructive hover:text-destructive"
                                                    onClick={() => removeItem(item.id)}
                                                    disabled={removingItem === item.id}
                                                >
                                                    <Trash2 className="size-4" />
                                                </Button>
                                            </div>
                                        </div>
                                        <div className="flex flex-col items-end justify-between">
                                            <span className="font-semibold">
                                                ${(Number(item.product.price) * item.quantity).toFixed(2)}
                                            </span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        <div className="lg:col-span-1">
                            <div className="sticky top-4 rounded-lg border border-sidebar-border bg-card p-6">
                                <h2 className="mb-4 text-xl font-semibold">Order Summary</h2>
                                <div className="space-y-2">
                                    <div className="flex justify-between text-sm">
                                        <span>Subtotal</span>
                                        <span>${Number(total).toFixed(2)}</span>
                                    </div>
                                    <div className="border-t border-sidebar-border pt-2">
                                        <div className="flex justify-between text-lg font-bold">
                                            <span>Total</span>
                                            <span>${Number(total).toFixed(2)}</span>
                                        </div>
                                    </div>
                                </div>
                                <Button
                                    className="mt-6 w-full"
                                    onClick={handleCheckout}
                                    disabled={processingCheckout}
                                >
                                    {processingCheckout ? 'Processing...' : 'Proceed to Checkout'}
                                </Button>
                                <Button
                                    variant="outline"
                                    className="mt-2 w-full"
                                    onClick={() => router.get('/products')}
                                >
                                    Continue Shopping
                                </Button>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
