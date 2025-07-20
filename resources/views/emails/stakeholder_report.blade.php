<!DOCTYPE html>
<html>
<head>
    <title>Stakeholder Report</title>
</head>
<body>
    <h2>Hello {{ $stakeholder->name }},</h2>
    <p>Here is your scheduled report:</p>

    @if(isset($data['inventory']))
        <h3>Inventory</h3>
        <ul>
            @foreach($data['inventory'] as $item)
                <li>{{ $item->name }}: {{ $item->quantity }}</li>
            @endforeach
        </ul>
    @endif

    @if(isset($data['orders']))
        <h3>Orders</h3>
        <ul>
            @foreach($data['orders'] as $order)
                <li>Order #{{ $order->id }} - {{ $order->status }}</li>
            @endforeach
        </ul>
    @endif

    @if(isset($data['procurement']))
        <h3>Procurement</h3>
        <ul>
            @foreach($data['procurement'] as $proc)
                <li>Procurement #{{ $proc->id }} - {{ $proc->status ?? 'N/A' }}</li>
            @endforeach
        </ul>
    @endif

    <p>Thank you,<br>Terravin Wine Company</p>
</body>
</html> 