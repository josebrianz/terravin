@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #f8f5f2 0%, #fff7f3 100%);
        font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    }
    .modern-glass-card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(80, 0, 20, 0.12);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: 2.5rem 2rem 2rem 2rem;
        margin-top: 3rem;
        transition: box-shadow 0.2s;
    }
    .modern-glass-card:hover {
        box-shadow: 0 12px 40px 0 rgba(123, 34, 48, 0.18);
    }
    .modern-header {
        background: linear-gradient(90deg, #7b2230 0%, #b85c38 100%);
        color: #fff;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        padding: 2rem 1rem 1.5rem 1rem;
        text-align: center;
        box-shadow: 0 2px 8px 0 rgba(123, 34, 48, 0.08);
    }
    .modern-icon {
        font-size: 3.5rem;
        color: #f8e7d1;
        margin-bottom: 1rem;
        filter: drop-shadow(0 2px 8px #b85c38aa);
    }
    .modern-btn {
        background: linear-gradient(90deg, #7b2230 0%, #b85c38 100%);
        color: #fff;
        border-radius: 2rem;
        padding: 0.7rem 2.2rem;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.03em;
        border: none;
        box-shadow: 0 2px 8px 0 #b85c3840;
        transition: background 0.2s, box-shadow 0.2s;
    }
    .modern-btn:hover {
        background: linear-gradient(90deg, #b85c38 0%, #7b2230 100%);
        color: #fff;
        box-shadow: 0 4px 16px 0 #7b223040;
    }
    .modern-status {
        color: #7b2230;
        font-size: 1.3rem;
        font-weight: 500;
        margin-bottom: 1.2rem;
    }
    .modern-desc {
        color: #b85c38;
        font-size: 1.05rem;
        margin-bottom: 2rem;
    }
    .modern-alert {
        border-radius: 1rem;
        font-size: 1.05rem;
        margin-top: 1.5rem;
    }
</style>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-7 col-lg-6">
        <div class="modern-glass-card">
            <div class="modern-header">
                <span class="modern-icon">
                    <i class="fas fa-wine-bottle"></i>
                </span>
                <h2 class="fw-bold mb-0" style="letter-spacing:0.03em;">Application Status</h2>
            </div>
            <div class="text-center py-4 px-2">
                <div class="modern-status">Your application for a new role is pending admin approval.</div>
                <div class="modern-desc">We appreciate your interest in joining our wine community!<br>
                    You will be notified by email once your request is processed.<br>
                    If you have questions, please <a href="mailto:support@terravin.com" style="color:#7b2230;text-decoration:underline;">contact support</a>.
                </div>
                @if (session('success'))
                    <div class="alert alert-success modern-alert">{{ session('success') }}</div>
                @endif
                @if (auth()->user()->role !== 'Customer')
                    <div class="alert alert-success modern-alert">
                        <i class="fas fa-glass-cheers me-2"></i>
                        Congratulations! Your application has been approved. You now have access to your {{ auth()->user()->role }} dashboard.<br>
                        @php
                            $dashboardUrl = '/dashboard';
                            if (auth()->user()->role === 'Retailer') {
                                $dashboardUrl = route('retailer.dashboard');
                            }
                        @endphp
                        <a href="{{ $dashboardUrl }}" class="modern-btn mt-3 d-inline-block">Go to Dashboard</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 