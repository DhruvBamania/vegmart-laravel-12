<div style="font-family: sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px;">
    <h1 style="color: #81c408; text-align: center;">Vegmart - Your One Stop for Groceries</h1>
    <h2>Order Confirmation</h2>
    <p>Hi {{ $order->first_name }},</p>
    <p>We've received your order <strong>#{{ $order->order_number }}</strong>!</p>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa;">
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Product</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Qty</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: right;">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $item->product->title }}</td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">{{ $item->quantity }}</td>
                <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">₹ {{ number_format($item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" style="padding: 10px; text-align: right;">Total Paid:</th>
                <th style="padding: 10px; text-align: right;">₹ {{ number_format($order->total, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 20px; font-size: 14px; color: #555;">
        <strong>Delivery to:</strong><br>
        {{ $order->address }}, {{ $order->city }}<br>
        Phone: {{ $order->mobile }}
    </div>
</div>