@extends('layouts.minimal')

@section('navbar')
<!-- Full admin-style wine-themed top bar -->
<div class="wine-top-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-2">
                <a class="wine-brand" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-wine-bottle"></i>
                </a>
            </div>
            <div class="col-md-7">
                <nav class="wine-nav">
                    <ul class="nav-links">
                        <li>
                            <a href="/dashboard" class="nav-link">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        @permission('manage_inventory')
                        <li><a href="{{ route('inventory.index') }}" class="nav-link">
                            <i class="fas fa-boxes"></i> Inventory
                        </a></li>
                        @endpermission
                        @permission('manage_procurement')
                        <li><a href="{{ route('procurement.dashboard') }}" class="nav-link">
                            <i class="fas fa-shopping-cart"></i> Procurement
                        </a></li>
                        @endpermission
                        @permission('view_orders')
                        <li><a href="{{ route('orders.index') }}" class="nav-link">
                            <i class="fas fa-shopping-bag"></i> Orders
                        </a></li>
                        @endpermission
                        @permission('manage_logistics')
                        <li><a href="{{ route('logistics.dashboard') }}" class="nav-link">
                            <i class="fas fa-truck"></i> Logistics
                        </a></li>
                        @endpermission
                        @if(Auth::user()->role === 'Wholesaler' || Auth::user()->role === 'Customer')
                        <li><a href="{{ route('chat.index') }}" class="nav-link">
                            <i class="fas fa-comments"></i> Chat
                        </a></li>
                        @endif
                        @if(Auth::user()->role !== 'Admin')
                        <li><a href="{{ route('help.index') }}" class="nav-link">
                            <i class="fas fa-question-circle"></i> Help
                        </a></li>
                        @endif
                        @role('Admin')
                        <li><a href="{{ route('admin.manage-roles') }}" class="nav-link">
                            <i class="fas fa-users-cog"></i> Users
                        </a></li>
                        <li><a href="{{ route('admin.role-approvals') }}" class="nav-link">
                            <i class="fas fa-user-check"></i> Role Requests
                            @if(\App\Models\RoleApprovalRequest::pending()->count() > 0)
                                <span class="badge bg-warning text-dark ms-1">{{ \App\Models\RoleApprovalRequest::pending()->count() }}</span>
                            @endif
                        </a></li>
                        @endrole
                        <li>
                            <a href="{{ route('forecast.dashboard') }}" class="nav-link">
                                <i class="fas fa-chart-line"></i> Forecast
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-3 text-end">
                <div class="user-info">
                    @auth
                        <div class="dropdown">
                            <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ time() }}" 
                                         alt="{{ Auth::user()->name }}" 
                                         class="rounded-circle me-2" style="width: 60px; height: 60px; object-fit: cover; border: 4px solid var(--gold);">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" 
                                         style="width: 60px; height: 60px; border: 4px solid var(--gold); background: linear-gradient(135deg, var(--burgundy) 0%, #8b1a1a 100%);">
                                        <span class="text-white fw-bold" style="font-size: 24px;">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role ms-1">({{ ucfirst(strtolower(Auth::user()->role)) }})</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-edit me-2"></i> Profile
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                                      onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a></li>
                            </ul>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    :root {
        --burgundy: #5e0f0f;
        --gold: #c8a97e;
        --cream: #f5f0e6;
        --light-burgundy: #8b1a1a;
        --dark-gold: #b8945f;
    }
    .wine-top-bar {
        background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%);
        color: white;
        padding: 0.75rem 0;
        box-shadow: 0 2px 10px rgba(94, 15, 15, 0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .wine-brand {
        color: var(--gold);
        text-decoration: none;
        font-size: 1.25rem;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    .wine-brand:hover {
        color: white;
        text-decoration: none;
    }
    .wine-nav {
        display: flex;
        justify-content: flex-start;
    }
    .nav-links {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 2.5rem;
        align-items: center;
    }
    .nav-link {
        color: var(--gold);
        text-decoration: none;
        font-size: 1.1rem;
        font-family: 'Playfair Display', serif;
        transition: color 0.2s;
    }
    .nav-link.active, .nav-link:hover {
        color: var(--cream);
        text-decoration: underline;
    }
    .user-info .dropdown-toggle {
        color: var(--gold);
        font-weight: 600;
        font-size: 1.1rem;
    }
    .user-info .user-name {
        margin-left: 0.5rem;
    }
    .user-info .user-role {
        color: var(--gold);
        font-size: 0.95rem;
        margin-left: 0.25rem;
    }
</style>
@endsection

@section('title', 'Customer Segmentation Dashboard')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .dashboard-section { margin-bottom: 2rem; }
        .chart-container { width: 100%; max-width: 600px; margin: auto; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Customer Segmentation Dashboard</h1>

    <div class="row dashboard-section">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Spending Segment Distribution</div>
                <div class="card-body chart-container">
                    <canvas id="spendingSegmentChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Wine Preference Distribution</div>
                <div class="card-body chart-container">
                    <canvas id="winePreferenceChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row dashboard-section">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Aggregate Spend & Quantity by Segment</div>
                <div class="card-body">
                    <table class="table table-bordered" id="spendingAggregateTable">
                        <thead>
                            <tr>
                                <th>Segment</th>
                                <th>Total Spend</th>
                                <th>Total Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Adjust these URLs if your FastAPI server is running elsewhere
    const API_BASE = 'http://127.0.0.1:5000';

    async function fetchData(endpoint) {
        const res = await fetch(`${API_BASE}${endpoint}`);
        return await res.json();
    }

    // Spending Segment Chart
    fetchData('/segments/spending-distribution').then(data => {
        const ctx = document.getElementById('spendingSegmentChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    data: Object.values(data),
                    backgroundColor: ['#5e0f0f', '#c8a97e', '#f5f0e6'],
                    borderColor: '#5e0f0f',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Customers'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Spending Segment'
                        }
                    }
                }
            }
        });
    });

    // Wine Preference Chart
    fetchData('/segments/wine-preference-distribution').then(data => {
        const ctx = document.getElementById('winePreferenceChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    data: Object.values(data),
                    backgroundColor: ['#5e0f0f', '#c8a97e', '#f5f0e6', '#8b1a1a'],
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });

    // Aggregate Spend & Quantity Table
    fetchData('/segments/spending-aggregate').then(data => {
        const tbody = document.querySelector('#spendingAggregateTable tbody');
        tbody.innerHTML = '';
        data.forEach(row => {
            tbody.innerHTML += `<tr>
                <td>${row.spending_segment_label}</td>
                <td>$${row.total_spend.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                <td>${row.QUANTITY}</td>
            </tr>`;
        });
    });
});
</script>
@endsection 