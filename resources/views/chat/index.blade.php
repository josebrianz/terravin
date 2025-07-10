@extends('layouts.admin')
@section('title', 'Chat')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card wine-card border-0 shadow-sm">
                <div class="card-header bg-burgundy text-gold d-flex align-items-center" style="border-radius: 1rem 1rem 0 0;">
                    <i class="fas fa-wine-bottle fa-lg me-2"></i>
                    <h4 class="mb-0 flex-grow-1">Start a Chat</h4>
                    <small class="text-gold ms-2">
                        {{ auth()->user()->role === 'Customer' ? 'Available Wholesalers' : 'Available Customers' }}
                    </small>
                </div>
                <div class="card-body bg-cream" style="border-radius: 0 0 1rem 1rem;">
                    @forelse($users as $user)
                        <div class="d-flex justify-content-between align-items-center p-3 mb-2 rounded wine-list-item" style="background: var(--cream); border: 1px solid var(--gold);">
                            <div>
                                <h6 class="mb-1 text-burgundy">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <a href="{{ route('chat.show', $user->id) }}" class="btn btn-gold btn-sm shadow-sm">
                                <i class="fas fa-comment"></i> Start Chat
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-burgundy mb-3"></i>
                            <p class="text-muted">No {{ auth()->user()->role === 'Customer' ? 'wholesalers' : 'customers' }} available to chat with.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
.bg-burgundy { background-color: #5e0f0f !important; }
.bg-cream { background-color: #f5f0e6 !important; }
.text-burgundy { color: #5e0f0f !important; }
.text-gold { color: #c8a97e !important; }
.btn-gold { background-color: #c8a97e; color: #5e0f0f; border: none; }
.btn-gold:hover { background-color: #b8945f; color: #fff; }
.wine-card { border-radius: 1rem; }
.wine-list-item { transition: background 0.2s; }
.wine-list-item:hover { background: #f5e6d0; }
</style>
@endpush
@endsection 