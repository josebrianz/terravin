<div style="font-family: 'Montserrat', Arial, sans-serif; background: #f9f5ed; color: #5e0f0f; padding: 2rem; border-radius: 12px;">
    <h2 style="color: #5e0f0f; font-family: 'Playfair Display', serif;">Thank You for Your Bulk Order!</h2>
    <p>Your bulk order has been received and is being processed. Here are your order details:</p>
    <ul style="list-style: none; padding: 0;">
        <li><strong>Order ID:</strong> {{ $order->id }}</li>
        <li><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</li>
        <li><strong>Total Amount:</strong> <span style="color: #c8a97e; font-weight: bold;">${{ number_format($order->total_amount, 2) }}</span></li>
    </ul>
    <h4 style="color: #5e0f0f;">Items Ordered:</h4>
    <ul>
        @foreach(json_decode($order->items, true) as $item)
            <li>{{ $item['wine_name'] }} ({{ $item['quantity'] }} units) - <span style="color: #c8a97e;">${{ number_format($item['unit_price'] * $item['quantity'], 2) }}</span></li>
        @endforeach
    </ul>
    <p style="margin-top: 2rem;">We appreciate your business and will notify you once your order is shipped.</p>
    <p style="color: #c8a97e;">- The Terravin Team</p>
</div> 