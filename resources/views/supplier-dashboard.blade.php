@extends('layouts.app')

@section('title', 'Supplier Dashboard')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-burgundy">Supplier Dashboard</h1>
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
        <!-- Example: List of supply orders -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Your Supply Orders</div>
                <div class="card-body">
                    <p>Coming soon: List of supply orders and their status.</p>
                </div>
            </div>
        </div>
        <!-- Example: Quick actions -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Quick Actions</div>
                <div class="card-body">
                    <a href="#" class="btn btn-primary mb-2">Create New Supply Order</a>
                    <a href="#" class="btn btn-secondary">View All Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 