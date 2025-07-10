@extends('layouts.app')

@section('title', 'Vendor Shipments')

@section('content')
<style>
    .shipments-theme-bg {
        background: linear-gradient(120deg, #f5f0e6 0%, #fff 60%, #f5e6e6 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', 'Figtree', Arial, sans-serif;
    }
    .shipments-card {
        border-radius: 22px;
        box-shadow: 0 6px 32px rgba(94, 15, 15, 0.13);
        border: none;
        background: #fff7f3;
        margin-bottom: 2rem;
    }
    .shipments-title {
        font-size: 2rem;
        font-weight: 800;
        color: #5e0f0f;
        margin-bottom: 1.5rem;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .shipments-table th, .shipments-table td {
        vertical-align: middle;
        font-size: 1.08rem;
    }
    .btn-burgundy {
        background-color: #5e0f0f !important;
        border-color: #5e0f0f !important;
        color: #fff !important;
        font-weight: 700;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(94, 15, 15, 0.10) !important;
        transition: all 0.2s !important;
    }
    .btn-burgundy:hover, .btn-burgundy:focus {
        background-color: #8b1a1a !important;
        border-color: #8b1a1a !important;
        color: #fff !important;
        box-shadow: 0 4px 16px rgba(94, 15, 15, 0.18) !important;
    }
</style>
<div class="shipments-theme-bg min-vh-100 py-5">
    <div class="container">
        <div class="shipments-card p-4">
            <div class="shipments-title">
                <i class="fas fa-truck text-gold"></i> Vendor Shipments
            </div>
            <p class="text-muted mb-4">This page will display all your shipment records. (No data yet.)</p>
            <table class="table table-hover shipments-table">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Cost</th>
                        <th>Estimated Delivery</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No shipments to display yet.</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ url('vendor/dashboard') }}" class="btn btn-burgundy mt-3">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection 