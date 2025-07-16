@extends('layouts.app')

@section('title', 'Wine Catalog')

@section('content')
<div class="container py-5 wine-catalog" style="background: linear-gradient(135deg, #fff7f3 0%, #f8e7d1 100%); min-height: 100vh;">
    <h2 class="mb-4 text-burgundy"><i class="fas fa-wine-bottle me-2"></i> Wine Catalog</h2>
    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search wines...">
                    <button class="btn btn-burgundy" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- Wine Grid -->
    <div class="row">
        @forelse($wines as $wine)
            <div class="col-md-4 mb-4">
                <div class="card wine-card shadow border-0 h-100">
                    <img src="{{ $wine->image_url ?? 'https://images.unsplash.com/photo-1514361892635-cebb9b6c7ca5?auto=format&fit=crop&w=400&q=80' }}" class="card-img-top" alt="{{ $wine->name }}" style="height: 220px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-burgundy">{{ $wine->name }}</h5>
                        <p class="card-text text-muted">{{ $wine->description }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-gold" style="color: #b85c38; font-size: 1.2rem;">{{ format_usd($wine->price) }}</span>
                            <a href="#" class="btn wine-btn" style="background: #b85c38; color: #fff;"><i class="fas fa-cart-plus me-1"></i> Add to Order</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">No wines found.</div>
            </div>
        @endforelse
    </div>
</div>
<style>
    .wine-catalog h2 {
        color: #7b2230;
        font-weight: bold;
    }
    .wine-card {
        border-radius: 1rem;
        transition: box-shadow 0.2s;
    }
    .wine-card:hover {
        box-shadow: 0 4px 24px rgba(123,34,48,0.15);
    }
    .btn-burgundy {
        background: #7b2230;
        color: #fff;
        border-radius: 2rem;
    }
    .btn-burgundy:hover {
        background: #b85c38;
        color: #fff;
    }
    .wine-btn {
        border-radius: 2rem;
        font-weight: bold;
        transition: background 0.2s, color 0.2s;
    }
    .wine-btn:hover {
        opacity: 0.85;
    }
    .text-burgundy {
        color: #7b2230 !important;
    }
    .text-gold {
        color: #c8a97e !important;
    }
</style>
@endsection 