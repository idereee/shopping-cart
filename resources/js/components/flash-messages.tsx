import { usePage } from '@inertiajs/react';
import { useEffect } from 'react';

interface FlashMessages {
    success?: string;
    error?: string;
}

export function FlashMessages() {
    const { flash } = usePage<{ flash: FlashMessages }>().props;

    useEffect(() => {
        if (flash?.success) {
            // For now, we'll use a simple alert. In production, use a toast library like sonner
            console.log('Success:', flash.success);
        }
        if (flash?.error) {
            console.log('Error:', flash.error);
        }
    }, [flash]);

    if (!flash?.success && !flash?.error) {
        return null;
    }

    return (
        <div className="fixed right-4 top-4 z-50 flex flex-col gap-2">
            {flash?.success && (
                <div className="animate-in slide-in-from-top-2 rounded-lg border border-green-200 bg-green-50 p-4 text-green-900 shadow-lg dark:border-green-800 dark:bg-green-900/20 dark:text-green-100">
                    <p className="text-sm font-medium">{flash.success}</p>
                </div>
            )}
            {flash?.error && (
                <div className="animate-in slide-in-from-top-2 rounded-lg border border-red-200 bg-red-50 p-4 text-red-900 shadow-lg dark:border-red-800 dark:bg-red-900/20 dark:text-red-100">
                    <p className="text-sm font-medium">{flash.error}</p>
                </div>
            )}
        </div>
    );
}
