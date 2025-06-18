@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Logistics Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Total Shipments</div>
                <div class="card-body">{{ $totalShipments }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Pending Shipments</div>
                <div class="card-body">{{ $pendingShipments }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">In Transit Shipments</div>
                <div class="card-body">{{ $inTransitShipments }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Delivered Shipments</div>
                <div class="card-body">{{ $deliveredShipments }}</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Shipments</div>
                <div class="card-body">
                    <ul>
                        @foreach($recentShipments as $shipment)
                            <li>{{ $shipment->id }} - {{ $shipment->status }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Recent Orders</div>
                <div class="card-body">
                    <ul>
                        @foreach($recentOrders as $order)
                            <li>{{ $order->id }} - {{ $order->created_at }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Low Stock Alerts</div>
                <div class="card-body">
                    <ul>
                        @foreach($lowStockItems as $item)
                            <li>{{ $item->name }} - Quantity: {{ $item->quantity }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 