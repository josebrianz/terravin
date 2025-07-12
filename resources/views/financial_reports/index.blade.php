@extends('layouts.app')

@section('title', 'Financial Reports')

@section('content')
<div class="container py-4 wine-theme-bg min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-burgundy">Financial Reports</h1>
        <div>
            <a href="#" class="btn btn-outline-gold me-2">Export CSV</a>
            <a href="#" class="btn btn-gold">Download PDF</a>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center mb-3">
                <div class="card-body">
                    <h6 class="fw-bold">Outstanding Invoices</h6>
                    <div class="display-6 fw-bold text-burgundy">UGX 12,000,000</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center mb-3">
                <div class="card-body">
                    <h6 class="fw-bold">Payments Received</h6>
                    <div class="display-6 fw-bold text-gold">UGX 8,000,000</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center mb-3">
                <div class="card-body">
                    <h6 class="fw-bold">Credit Terms</h6>
                    <div class="display-6 fw-bold">Net 30</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-cream">
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Jul 01, 2025</td>
                        <td>Invoice</td>
                        <td>UGX 2,000,000</td>
                        <td><span class="badge bg-warning text-dark">Outstanding</span></td>
                    </tr>
                    <tr>
                        <td>Jun 28, 2025</td>
                        <td>Payment</td>
                        <td>UGX 1,500,000</td>
                        <td><span class="badge bg-success">Received</span></td>
                    </tr>
                    <tr>
                        <td>Jun 20, 2025</td>
                        <td>Invoice</td>
                        <td>UGX 3,000,000</td>
                        <td><span class="badge bg-warning text-dark">Outstanding</span></td>
                    </tr>
                    <tr>
                        <td>Jun 15, 2025</td>
                        <td>Payment</td>
                        <td>UGX 2,000,000</td>
                        <td><span class="badge bg-success">Received</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 