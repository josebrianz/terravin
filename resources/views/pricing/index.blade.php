@extends('layouts.app')

@section('title', 'Pricing & Discounts')

@section('content')
<div class="container py-4 wine-theme-bg min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-burgundy">Pricing & Discounts</h1>
        <a href="#" class="btn btn-gold">Add Pricing/Discount</a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-cream">
                    <tr>
                        <th>Product</th>
                        <th>Base Price</th>
                        <th>Bulk Discount</th>
                        <th>Promo Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Chateau Rouge</td>
                        <td>{{ 'UGX ' . number_format(20000, 0) }}</td>
                        <td>10% for 100+</td>
                        <td>{{ 'UGX ' . number_format(18000, 0) }}</td>
                        <td><a href="#" class="btn btn-sm btn-outline-burgundy">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Vintner's Reserve</td>
                        <td>{{ 'UGX ' . number_format(25000, 0) }}</td>
                        <td>8% for 50+</td>
                        <td>{{ 'UGX ' . number_format(23000, 0) }}</td>
                        <td><a href="#" class="btn btn-sm btn-outline-burgundy">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Golden Barrel</td>
                        <td>{{ 'UGX ' . number_format(15000, 0) }}</td>
                        <td>5% for 200+</td>
                        <td>{{ 'UGX ' . number_format(14000, 0) }}</td>
                        <td><a href="#" class="btn btn-sm btn-outline-burgundy">Edit</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 