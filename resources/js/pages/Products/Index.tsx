import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/react';
import { ShoppingCart } from 'lucide-react';
import { useState } from 'react';

interface Product {
    id: number;
    name: string;
    description: string | null;
    price: number;
    stock_quantity: number;
    image_url: string | null;
}

interface Props {
    products: Product[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];

export default function ProductsIndex() {
    const { products } = usePage<Props>().props;
    const [addingToCart, setAddingToCart] = useState<number | null>(null);

    const addToCart = (productId: number) => {
        setAddingToCart(productId);
        router.post(
            '/cart',
            {
                product_id: productId,
                quantity: 1,
            },
            {
                preserveScroll: true,
                onFinish: () => setAddingToCart(null),
            }
        );
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Products" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6">
                <div className="flex items-center justify-between">
                    <h1 className="text-3xl font-bold">Products</h1>
                </div>

                <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    {products.map((product) => (
                        <div
                            key={product.id}
                            className="group overflow-hidden rounded-lg border border-sidebar-border bg-card transition-all hover:shadow-lg"
                        >
                            <div className="relative aspect-square overflow-hidden bg-muted">
                                {product.image_url ? (
                                    <img
                                        src={product.image_url}
                                        alt={product.name}
                                        className="size-full object-cover transition-transform group-hover:scale-105"
                                    />
                                ) : (
                                    <div className="flex size-full items-center justify-center bg-muted">
                                        <ShoppingCart className="size-16 text-muted-foreground" />
                                    </div>
                                )}
                                {product.stock_quantity <= 5 && product.stock_quantity > 0 && (
                                    <div className="absolute right-2 top-2 rounded-md bg-yellow-500 px-2 py-1 text-xs font-semibold text-white">
                                        Low Stock
                                    </div>
                                )}
                                {product.stock_quantity === 0 && (
                                    <div className="absolute right-2 top-2 rounded-md bg-red-500 px-2 py-1 text-xs font-semibold text-white">
                                        Out of Stock
                                    </div>
                                )}
                            </div>
                            <div className="flex flex-col gap-2 p-4">
                                <h3 className="font-semibold">{product.name}</h3>
                                <p className="line-clamp-2 text-sm text-muted-foreground">
                                    {product.description}
                                </p>
                                <div className="mt-auto flex items-center justify-between pt-2">
                                    <span className="text-lg font-bold">
                                        ${Number(product.price).toFixed(2)}
                                    </span>
                                    <span className="text-sm text-muted-foreground">
                                        {product.stock_quantity} in stock
                                    </span>
                                </div>
                                <Button
                                    onClick={() => addToCart(product.id)}
                                    disabled={product.stock_quantity === 0 || addingToCart === product.id}
                                    className="w-full"
                                >
                                    {addingToCart === product.id ? (
                                        'Adding...'
                                    ) : product.stock_quantity === 0 ? (
                                        'Out of Stock'
                                    ) : (
                                        <>
                                            <ShoppingCart className="mr-2 size-4" />
                                            Add to Cart
                                        </>
                                    )}
                                </Button>
                            </div>
                        </div>
                    ))}
                </div>

                {products.length === 0 && (
                    <div className="flex flex-col items-center justify-center py-12">
                        <ShoppingCart className="mb-4 size-16 text-muted-foreground" />
                        <h2 className="text-xl font-semibold">No products available</h2>
                        <p className="text-muted-foreground">Check back later for new products.</p>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}
