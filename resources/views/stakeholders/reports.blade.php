@extends('layout')

@section('title', 'Generated Reports')

@section('content')
<div class="container py-4">
    <h1>Generated Reports for {{ $stakeholder->name }}</h1>
    @if(empty($reportData))
        <p>No report data available for this stakeholder.</p>
    @else
        @if(isset($reportData['inventory']))
            <h3>Inventory</h3>
            <ul>
                @foreach($reportData['inventory'] as $item)
                    <li>{{ $item->name }}: {{ $item->quantity }}</li>
                @endforeach
            </ul>
        @endif
        @if(isset($reportData['orders']))
            <h3>Orders</h3>
            <ul>
                @foreach($reportData['orders'] as $order)
                    <li>Order #{{ $order->id }} - {{ $order->status }}</li>
                @endforeach
            </ul>
        @endif
        @if(empty($reportData['inventory']) && empty($reportData['orders']))
            <p>No inventory or order data available for this stakeholder's report preferences.</p>
        @endif
    @endif
</div>
@endsection
