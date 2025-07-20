<!DOCTYPE html>
<html>
<head>
    <title>Generated Reports</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1, h3 { color: #333; }
        ul { padding-left: 20px; }
    </style>
</head>
<body>
    <h1>Generated Reports</h1>
    @if(empty($reportData))
        <p>No report data available for this stakeholder.</p>
    @else
        @if(isset($reportData['inventory']))
            <h3>Inventory</h3>
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($reportData['inventory'] as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->category ?? 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(isset($reportData['orders']))
            <h3>Orders</h3>
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($reportData['orders'] as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->total_amount ?? 'N/A' }}</td>
                        <td>{{ $order->created_at ? $order->created_at->format('Y-m-d') : 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(isset($reportData['procurement']))
            <h3>Procurement</h3>
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Procurement #</th>
                        <th>Status</th>
                        <th>Requested By</th>
                        <th>Total Cost</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($reportData['procurement'] as $proc)
                    <tr>
                        <td>{{ $proc->id }}</td>
                        <td>{{ $proc->status ?? 'N/A' }}</td>
                        <td>{{ $proc->requested_by ?? ($proc->user->name ?? 'N/A') }}</td>
                        <td>{{ $proc->total_cost ?? 'N/A' }}</td>
                        <td>{{ $proc->created_at ? $proc->created_at->format('Y-m-d') : 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @if(empty($reportData['inventory']) && empty($reportData['orders']))
            <p>No inventory or order data available for this stakeholder's report preferences.</p>
        @endif
    @endif
</body>
</html> 