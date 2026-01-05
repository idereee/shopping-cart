<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Headphones',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life.',
                'price' => 129.99,
                'stock_quantity' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Smartphone Stand',
                'description' => 'Adjustable aluminum smartphone stand for desk use.',
                'price' => 24.99,
                'stock_quantity' => 3,
                'image_url' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbdb?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Laptop Backpack',
                'description' => 'Water-resistant backpack with padded laptop compartment up to 15.6 inches.',
                'price' => 49.99,
                'stock_quantity' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'USB-C Hub',
                'description' => '7-in-1 USB-C hub with HDMI, USB 3.0, and SD card reader.',
                'price' => 39.99,
                'stock_quantity' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1625948515291-69613efd103f?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical keyboard with blue switches and premium keycaps.',
                'price' => 89.99,
                'stock_quantity' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with adjustable DPI and rechargeable battery.',
                'price' => 34.99,
                'stock_quantity' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Monitor Arm',
                'description' => 'Single monitor arm mount with full motion adjustment.',
                'price' => 79.99,
                'stock_quantity' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Desk Lamp',
                'description' => 'LED desk lamp with touch control and adjustable color temperature.',
                'price' => 44.99,
                'stock_quantity' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Webcam HD',
                'description' => '1080p HD webcam with built-in microphone and auto-focus.',
                'price' => 59.99,
                'stock_quantity' => 1,
                'image_url' => 'https://images.unsplash.com/photo-1587826080692-f439cd0b70da?w=500&h=500&fit=crop',
            ],
            [
                'name' => 'Cable Organizer',
                'description' => 'Cable management box with multiple compartments.',
                'price' => 19.99,
                'stock_quantity' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
