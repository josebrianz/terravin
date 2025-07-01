@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-burgundy">Vendor Dashboard</h1>
    <div class="mb-3">
        Welcome, <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})
    </div>
    <div class="mb-4">
        <a href="{{ route('logout') }}" class="btn btn-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <div class="row">
        <!-- Example: List of products -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Your Products</div>
                <div class="card-body">
                    <p>Coming soon: List of products and sales stats.</p>
                </div>
            </div>
        </div>
        <!-- Example: Quick actions -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Quick Actions</div>
                <div class="card-body">
                    <a href="#" class="btn btn-primary mb-2">Add New Product</a>
                    <a href="#" class="btn btn-secondary">View Sales</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 