<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alert</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
        }
        .product-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .product-details h3 {
            margin-top: 0;
        }
        .stock-level {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Low Stock Alert</h1>
    </div>

    <div class="alert">
        <strong>Warning:</strong> A product in your inventory is running low on stock!
    </div>

    <div class="product-details">
        <h3>{{ $product->name }}</h3>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
        <p><strong>Current Stock Level:</strong> <span class="stock-level">{{ $product->stock_quantity }}</span> units</p>
    </div>

    <p>Please restock this item soon to avoid running out of inventory.</p>

    <p style="color: #6c757d; font-size: 12px; margin-top: 30px;">
        This is an automated notification from your E-commerce Shopping Cart System.
    </p>
</body>
</html>
