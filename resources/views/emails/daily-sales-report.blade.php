<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>
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
        .summary {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .stat {
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .stat-label {
            font-size: 12px;
            color: #6c757d;
        }
        .orders-list {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-item {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .no-sales {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daily Sales Report</h1>
        <p>Report for {{ $date }}</p>
    </div>

    @if($orders->count() > 0)
        <div class="summary">
            <strong>Summary</strong>
            <div class="summary-stats">
                <div class="stat">
                    <div class="stat-value">{{ $orders->count() }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat">
                    <div class="stat-value">{{ $totalItems }}</div>
                    <div class="stat-label">Items Sold</div>
                </div>
                <div class="stat">
                    <div class="stat-value">${{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
            </div>
        </div>

        <div class="orders-list">
            <h3 style="margin-top: 0;">Order Details</h3>
            @foreach($orders as $order)
                <div class="order-item">
                    <p style="margin: 5px 0;">
                        <strong>Order #{{ $order->id }}</strong> -
                        {{ $order->user->name }} ({{ $order->user->email }})
                    </p>
                    <p style="margin: 5px 0; color: #6c757d; font-size: 14px;">
                        Items: {{ $order->items_count }} |
                        Total: ${{ number_format($order->total, 2) }} |
                        Time: {{ $order->created_at->format('h:i A') }}
                    </p>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-sales">
            <strong>No Sales Today</strong>
            <p>There were no orders placed on {{ $date }}.</p>
        </div>
    @endif

    <p style="color: #6c757d; font-size: 12px; margin-top: 30px;">
        This is an automated daily sales report from your E-commerce Shopping Cart System.
    </p>
</body>
</html>
