@extends('layouts.app')

@section('title', 'Vendor Messages')

@section('content')
<style>
    .messages-theme-bg {
        background: linear-gradient(120deg, #f5f0e6 0%, #fff 60%, #f5e6e6 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', 'Figtree', Arial, sans-serif;
    }
    .messages-card {
        border-radius: 22px;
        box-shadow: 0 6px 32px rgba(94, 15, 15, 0.13);
        border: none;
        background: #fff7f3;
        margin-bottom: 2rem;
        padding: 2.5rem 2rem;
    }
    .messages-title {
        font-size: 2rem;
        font-weight: 800;
        color: #5e0f0f;
        margin-bottom: 1.5rem;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
<div class="messages-theme-bg min-vh-100 py-5">
    <div class="container">
        <div class="messages-card">
            <div class="messages-title">
                <i class="fas fa-comments text-gold"></i> Vendor Messages
            </div>
            <div class="alert alert-info mb-4">No messages yet. This page will show your vendor communications.</div>
            <a href="{{ url('vendor/dashboard') }}" class="btn btn-burgundy mt-3">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection 