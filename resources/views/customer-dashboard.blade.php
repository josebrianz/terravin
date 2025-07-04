{{-- Corrected Blade syntax --}}
@section('content')
    <div class="wine-dashboard position-relative py-5">
        @php
            $userEmail = auth()->user()->email;
            $totalOrders = \App\Models\Order::where('customer_email', $userEmail)->count();
            $activeOrders = \App\Models\Order::where('customer_email', $userEmail)
                                ->whereIn('status', ['pending', 'processing'])
                                ->count();
            $deliveredOrders = \App\Models\Order::where('customer_email', $userEmail)
                                  ->where('status', 'delivered')
                                  ->count();
            $recentOrders = \App\Models\Order::where('customer_email', $userEmail)
                               ->latest()
                               ->take(5)
                               ->get();
        @endphp
        
        {{-- Rest of your HTML content --}}
    </div>
@endsection

@push('styles')
    <style>
        :root {
    --primary: #7a1a1a;
    --primary-light: #9e2a2a;
    --secondary: #c8a97e;
    --light: #f8f5f0;
    --dark: #2a2a2a;
    --success: #4a8c5e;
    --warning: #e4a83b;
    --info: #3b82e4;
}

/* Base Styles */
.wine-dashboard {
    background-color: var(--light);
    min-height: 100vh;
    position: relative;
    overflow: hidden;
}

/* Decorative Elements */
.wine-decoration {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 0;
}

.grape-cluster {
    position: absolute;
    top: 5%;
    left: 5%;
    width: 120px;
    height: 120px;
    background-image: url('https://cdn.pixabay.com/photo/2013/07/13/12/46/grapes-146313_1280.png');
    background-size: contain;
    background-repeat: no-repeat;
    opacity: 0.08;
}

.wine-bottle {
    position: absolute;
    bottom: 5%;
    right: 5%;
    width: 150px;
    height: 300px;
    background-image: url('https://cdn.pixabay.com/photo/2012/04/13/00/22/wine-31212_1280.png');
    background-size: contain;
    background-repeat: no-repeat;
    opacity: 0.06;
}

.vine-leaf {
    position: absolute;
    top: 30%;
    right: 10%;
    width: 100px;
    height: 100px;
    background-image: url('https://cdn.pixabay.com/photo/2012/04/24/13/49/vine-40702_1280.png');
    background-size: contain;
    background-repeat: no-repeat;
    opacity: 0.07;
    transform: rotate(15deg);
}

/* Header Section */
.dashboard-header {
    position: relative;
    z-index: 1;
}

.welcome-message h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1rem;
    font-family: 'Playfair Display', serif;
}

.welcome-message .wine-icon {
    color: var(--primary);
    margin-right: 10px;
}

.text-gradient {
    background: linear-gradient(90deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.user-profile-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    border: 1px solid rgba(0,0,0,0.05);
}

.profile-avatar {
    width: 60px;
    height: 60px;
    background: var(--light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 2rem;
    color: var(--primary);
}

.profile-info h5 {
    margin-bottom: 0.2rem;
    font-weight: 600;
}

/* Stats Section */
.stats-section {
    position: relative;
    z-index: 1;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 1.5rem;
    color: white;
}

.total-orders .stat-icon {
    background: var(--primary);
}

.active-orders .stat-icon {
    background: var(--warning);
}

.delivered-orders .stat-icon {
    background: var(--success);
}

.stat-content h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.2rem;
    color: var(--dark);
}

.stat-content p {
    color: var(--dark);
    opacity: 0.7;
    margin-bottom: 0;
}

/* Action Buttons */
.action-buttons {
    position: relative;
    z-index: 1;
}

.btn-icon {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
    margin: 0 5px;
}

.btn-primary {
    background: var(--primary);
    border-color: var(--primary);
}

.btn-primary:hover {
    background: var(--primary-light);
    border-color: var(--primary-light);
}

.btn-outline-primary {
    color: var(--primary);
    border-color: var(--primary);
}

.btn-outline-primary:hover {
    background: var(--primary);
    color: white;
}

.btn-secondary {
    background: var(--secondary);
    border-color: var(--secondary);
    color: white;
}

.btn-secondary:hover {
    background: var(--secondary);
    opacity: 0.9;
    color: white;
}

/* Recent Orders Section */
.recent-orders-section {
    position: relative;
    z-index: 1;
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0;
}

.view-all {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
}

.view-all:hover {
    text-decoration: underline;
}

.orders-table {
    margin-top: 20px;
}

.order-card {
    background: var(--light);
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    border-left: 4px solid var(--primary);
}

.order-card:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.order-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.order-number {
    font-weight: 600;
    color: var(--dark);
}

.order-date {
    color: var(--dark);
    opacity: 0.7;
    font-size: 0.9rem;
}

.order-body {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.8rem;
}

.status-pending {
    background-color: rgba(228, 168, 59, 0.2);
    color: var(--warning);
}

.status-processing {
    background-color: rgba(59, 130, 228, 0.2);
    color: var(--info);
}

.status-delivered {
    background-color: rgba(74, 140, 94, 0.2);
    color: var(--success);
}

.btn-outline {
    border: 1px solid var(--primary);
    color: var(--primary);
    padding: 5px 15px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background: var(--primary);
    color: white;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
}

.empty-state i {
    font-size: 3rem;
    color: var(--primary);
    opacity: 0.5;
    margin-bottom: 20px;
}

.empty-state p {
    color: var(--dark);
    opacity: 0.7;
    margin-bottom: 20px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .welcome-message h1 {
        font-size: 2rem;
    }
    
    .user-profile-card {
        flex-direction: column;
        text-align: center;
        padding: 15px;
    }
    
    .profile-avatar {
        margin-right: 0;
        margin-bottom: 15px;
    }
    
    .action-buttons .btn-group-lg {
        display: flex;
        flex-direction: column;
    }
    
    .action-buttons .btn {
        margin: 5px 0;
        width: 100%;
    }
    
    .order-header, .order-body {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .order-body .btn-outline {
        margin-top: 10px;
    }

    </style>
@endpush