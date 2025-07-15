@extends('layouts.admin')

@section('title', 'Wine Inventory Management - Terravin Wine')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-boxes me-2 text-gold"></i>
                        Wine Inventory Management
                    </h1>
                    <span class="text-muted small">Track wine stock levels, manage inventory, and monitor product availability</span>
                </div>
                <div class="header-actions">
                    <a href="{{ route('inventory.create') }}" class="btn btn-burgundy shadow-sm" title="Add a new wine item">
                        <i class="fas fa-plus"></i> Add New Wine Item
                    </a>
                    <span class="badge bg-gold text-burgundy px-3 py-2 ms-3">
                        <i class="fas fa-clock me-1"></i>
                        {{ now()->format('M d, Y H:i') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Inventory Table -->
    <div class="card wine-card shadow-sm border-0">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="card-title mb-0 fw-bold text-burgundy">
                <i class="fas fa-wine-bottle text-gold me-2"></i> Wine Inventory List
            </h5>
        </div>
        <div class="card-body">
            @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-burgundy fw-bold">#</th>
                                <th class="text-burgundy fw-bold">Image</th>
                                <th class="text-burgundy fw-bold">Wine Name</th>
                                <th class="text-burgundy fw-bold">SKU</th>
                                <th class="text-burgundy fw-bold">Category</th>
                                <th class="text-burgundy fw-bold">Quantity</th>
                                <th class="text-burgundy fw-bold">Price</th>
                                <th class="text-burgundy fw-bold">Location</th>
                                <th class="text-burgundy fw-bold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr class="wine-list-item">
                                <td>
                                    <span class="badge bg-burgundy text-gold">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    @if(!empty($item->images) && is_array($item->images) && count($item->images) > 0)
                                        <img src="{{ asset('storage/' . $item->images[0]) }}" alt="Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong class="text-burgundy">{{ $item->name }}</strong>
                                        @if($item->quantity < 10)
                                            <span class="badge bg-danger ms-2">Low Stock</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <code class="text-gold">{{ $item->sku }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-gold text-burgundy">{{ $item->category }}</span>
                                </td>
                                <td>
                                    @if($item->quantity > 20)
                                        <span class="badge bg-success">{{ $item->quantity }}</span>
                                    @elseif($item->quantity > 10)
                                        <span class="badge bg-warning text-dark">{{ $item->quantity }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $item->quantity }}</span>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-burgundy">${{ number_format($item->unit_price, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $item->location ?? 'Main Storage' }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('inventory.edit', $item->id) }}" 
                                           class="btn btn-outline-gold" title="Edit wine item">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('inventory.destroy', $item->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this wine item?')">
                                            @csrf 
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger" title="Delete wine item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $items->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="icon-circle bg-burgundy mx-auto mb-3">
                        <i class="fas fa-boxes fa-2x text-gold"></i>
                    </div>
                    <h5 class="text-burgundy fw-bold">No wine items found</h5>
                    <p class="text-muted">Start by adding your first wine item to the inventory.</p>
                    <a href="{{ route('inventory.create') }}" class="btn btn-burgundy">
                        <i class="fas fa-plus"></i> Add First Wine Item
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    @if($items->count() > 0)
    <div class="row mt-4 g-3">
        <div class="col-md-3">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-burgundy mb-3">
                        <i class="fas fa-boxes fa-2x text-gold"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy">{{ $items->count() }}</h4>
                    <span class="text-muted small">Total Wine Items</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-gold mb-3">
                        <i class="fas fa-exclamation-triangle fa-2x text-burgundy"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy">{{ $items->where('quantity', '<', 10)->count() }}</h4>
                    <span class="text-muted small">Low Stock Items</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-burgundy mb-3">
                        <i class="fas fa-coins fa-2x text-gold"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy">${{ number_format($items->sum('unit_price'), 0) }}</h4>
                    <span class="text-muted small">Total Value</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card wine-card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="icon-circle bg-gold mb-3">
                        <i class="fas fa-check-circle fa-2x text-burgundy"></i>
                    </div>
                    <h4 class="mb-0 fw-bold text-burgundy">{{ $items->where('quantity', '>', 20)->count() }}</h4>
                    <span class="text-muted small">Well Stocked</span>
                </div>
            </div>
        </div>
    </div>
    @endif
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

.btn-outline-gold {
    color: var(--gold);
    border-color: var(--gold);
}

.btn-outline-gold:hover {
    background-color: var(--gold);
    border-color: var(--gold);
    color: var(--burgundy);
}

.wine-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.wine-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(94, 15, 15, 0.15) !important;
}

.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.wine-list-item {
    transition: background-color 0.2s ease;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.wine-list-item:hover {
    background-color: var(--cream);
}

.header-actions .badge {
    border-radius: 20px;
    font-weight: 500;
}

.card-header {
    border-bottom: 2px solid var(--cream);
    background: linear-gradient(135deg, #fff 0%, var(--cream) 100%);
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
