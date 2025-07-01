@extends('layouts.admin')

@section('title', 'Wine Catalog - Terravin Wine')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-wine-bottle me-2 text-gold"></i>
                        Wine Catalog
                    </h1>
                    <span class="text-muted small">Browse our premium selection of wines</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('orders.create') }}" class="btn btn-burgundy" title="Create new order">
                        <i class="fas fa-shopping-cart"></i> Place Order
                    </a>
                    <span class="badge bg-gold text-burgundy px-3 py-2 ms-3">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Wine Categories -->
    @foreach($categories as $category => $wines)
    <div class="row mb-5">
        <div class="col-12">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-header bg-burgundy text-gold">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>
                        {{ $category }}
                    </h3>
                </div>
                <div class="card-body bg-cream">
                    <div class="row g-4">
                        @foreach($wines as $wine)
                        <div class="col-lg-4 col-md-6">
                            <div class="wine-item-card h-100 border rounded p-3 bg-white shadow-sm">
                                <div class="wine-item-header mb-3">
                                    <h5 class="wine-name text-burgundy fw-bold mb-1">{{ $wine->name }}</h5>
                                    <div class="wine-meta d-flex justify-content-between align-items-center">
                                        <span class="badge bg-gold text-burgundy">{{ $wine->category }}</span>
                                        <span class="text-muted small">SKU: {{ $wine->sku }}</span>
                                    </div>
                                </div>
                                
                                <div class="wine-description mb-3">
                                    <p class="text-muted small mb-2">{{ $wine->description }}</p>
                                </div>
                                
                                <div class="wine-details mb-3">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="detail-item">
                                                <div class="detail-label text-muted small">Price</div>
                                                <div class="detail-value text-burgundy fw-bold">{{ $wine->getFormattedPrice() }}</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="detail-item">
                                                <div class="detail-label text-muted small">Stock</div>
                                                <div class="detail-value {{ $wine->isLowStock() ? 'text-warning' : 'text-success' }} fw-bold">
                                                    {{ $wine->quantity }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="detail-item">
                                                <div class="detail-label text-muted small">Location</div>
                                                <div class="detail-value text-muted small">{{ $wine->location }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="wine-actions">
                                    <div class="d-grid">
                                        <a href="{{ route('orders.create') }}" class="btn btn-outline-burgundy btn-sm">
                                            <i class="fas fa-plus"></i> Add to Order
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Quick Order Button -->
    <div class="row">
        <div class="col-12 text-center">
            <div class="card wine-card border-0 shadow-sm">
                <div class="card-body bg-cream">
                    <h4 class="text-burgundy mb-3">Ready to place your order?</h4>
                    <a href="{{ route('orders.create') }}" class="btn btn-burgundy btn-lg">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Start Your Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
    --dark-gold: #b8945f;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.1);
}

.page-title {
    margin: 0;
}

.text-burgundy {
    color: var(--burgundy) !important;
}

.text-gold {
    color: var(--gold) !important;
}

.bg-burgundy {
    background-color: var(--burgundy) !important;
}

.bg-gold {
    background-color: var(--gold) !important;
}

.bg-cream {
    background-color: var(--cream) !important;
}

.btn-burgundy {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.btn-burgundy:hover {
    background-color: var(--light-burgundy);
    border-color: var(--light-burgundy);
    color: white;
}

.btn-outline-burgundy {
    color: var(--burgundy);
    border-color: var(--burgundy);
}

.btn-outline-burgundy:hover {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.wine-card {
    border-radius: 1rem;
    overflow: hidden;
}

.wine-item-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 12px;
}

.wine-item-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(94, 15, 15, 0.15) !important;
}

.wine-name {
    font-size: 1.1rem;
    line-height: 1.3;
}

.detail-item {
    padding: 0.5rem;
}

.detail-label {
    font-size: 0.8rem;
    margin-bottom: 0.25rem;
}

.detail-value {
    font-size: 1rem;
}

.wine-meta {
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .header-actions {
        order: -1;
    }
}
</style>
@endpush
@endsection 