@extends('layouts.admin')

@section('title', 'Help & Support - Terravin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4">
                <h1 class="page-title mb-0 fw-bold text-burgundy">
                    <i class="fas fa-question-circle me-2 text-gold"></i>
                    Help & Support Center
                </h1>
                <span class="text-muted small">Find answers to common questions and learn how to use Terravin effectively</span>
            </div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-body">
                    <h5 class="card-title text-burgundy fw-bold mb-3">
                        <i class="fas fa-compass text-gold me-2"></i>
                        Quick Navigation
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="#getting-started" class="btn btn-outline-burgundy w-100 text-start">
                                <i class="fas fa-rocket me-2"></i>Getting Started
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#orders" class="btn btn-outline-burgundy w-100 text-start">
                                <i class="fas fa-shopping-cart me-2"></i>Orders
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#chat" class="btn btn-outline-burgundy w-100 text-start">
                                <i class="fas fa-comments me-2"></i>Chat System
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#profile" class="btn btn-outline-burgundy w-100 text-start">
                                <i class="fas fa-user me-2"></i>Profile Management
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Getting Started Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm wine-card mb-4" id="getting-started">
                <div class="card-header bg-white border-bottom-0">
                    <h4 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-rocket text-gold me-2"></i>
                        Getting Started
                    </h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="gettingStartedAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    <i class="fas fa-user-plus text-gold me-2"></i>
                                    How do I create an account?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>To create an account:</p>
                                    <ol>
                                        <li>Click on the "Register" link in the top navigation</li>
                                        <li>Fill in your name, email address, and choose a password</li>
                                        <li>Select your role (Customer, Wholesaler, etc.)</li>
                                        <li>Click "Register" to create your account</li>
                                        <li>Check your email for verification link</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    <i class="fas fa-sign-in-alt text-gold me-2"></i>
                                    How do I log in?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>To log in to your account:</p>
                                    <ol>
                                        <li>Go to the login page</li>
                                        <li>Enter your email address and password</li>
                                        <li>Click "Log in"</li>
                                        <li>If you forgot your password, use the "Forgot password?" link</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    <i class="fas fa-users text-gold me-2"></i>
                                    What are the different user roles?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-burgundy fw-bold">Customer</h6>
                                            <p class="small">Browse and order wines, chat with suppliers</p>
                                            
                                            <h6 class="text-burgundy fw-bold">Wholesaler</h6>
                                            <p class="small">Manage wine inventory, fulfill orders, chat with customers</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-burgundy fw-bold">Admin</h6>
                                            <p class="small">Full system access, user management, analytics</p>
                                            
                                            <h6 class="text-burgundy fw-bold">Vendor</h6>
                                            <p class="small">Manage inventory, process orders</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="card border-0 shadow-sm wine-card mb-4" id="orders">
                <div class="card-header bg-white border-bottom-0">
                    <h4 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-shopping-cart text-gold me-2"></i>
                        Orders & Shopping
                    </h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="ordersAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                    <i class="fas fa-search text-gold me-2"></i>
                                    How do I browse and order wines?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>To browse and order wines:</p>
                                    <ol>
                                        <li>Go to the "Orders" section in your dashboard</li>
                                        <li>Browse the wine catalog with filters and search</li>
                                        <li>Click on a wine to view details</li>
                                        <li>Add desired quantity to your cart</li>
                                        <li>Review your cart and proceed to checkout</li>
                                        <li>Complete your order with shipping details</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                    <i class="fas fa-truck text-gold me-2"></i>
                                    How do I track my orders?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>To track your orders:</p>
                                    <ol>
                                        <li>Go to "Orders" in your dashboard</li>
                                        <li>Find your order in the list</li>
                                        <li>Click on the order to view details</li>
                                        <li>Check the status and tracking information</li>
                                        <li>Contact support if you need assistance</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                                    <i class="fas fa-undo text-gold me-2"></i>
                                    Can I cancel or modify my order?
                                </button>
                            </h2>
                            <div id="collapse6" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Order modification policies:</p>
                                    <ul>
                                        <li><strong>Pending Orders:</strong> Can be cancelled or modified</li>
                                        <li><strong>Processing Orders:</strong> Contact supplier directly via chat</li>
                                        <li><strong>Shipped Orders:</strong> Cannot be cancelled, contact support for returns</li>
                                        <li><strong>Returns:</strong> Subject to supplier's return policy</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat System Section -->
            <div class="card border-0 shadow-sm wine-card mb-4" id="chat">
                <div class="card-header bg-white border-bottom-0">
                    <h4 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-comments text-gold me-2"></i>
                        Chat System
                    </h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="chatAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">
                                    <i class="fas fa-comment-dots text-gold me-2"></i>
                                    How do I start a chat?
                                </button>
                            </h2>
                            <div id="collapse7" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>To start a chat:</p>
                                    <ol>
                                        <li>Click on "Chat" in the navigation menu</li>
                                        <li>Select a contact from the list (customers/suppliers)</li>
                                        <li>Type your message in the chat box</li>
                                        <li>Press Enter or click Send</li>
                                        <li>You'll receive notifications for new messages</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8">
                                    <i class="fas fa-bell text-gold me-2"></i>
                                    How do I manage chat notifications?
                                </button>
                            </h2>
                            <div id="collapse8" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>Chat notification features:</p>
                                    <ul>
                                        <li><strong>Real-time notifications:</strong> New messages appear instantly</li>
                                        <li><strong>Unread indicators:</strong> Red badges show unread messages</li>
                                        <li><strong>Sound alerts:</strong> Optional audio notifications</li>
                                        <li><strong>Email notifications:</strong> Receive email alerts for important messages</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Profile Management -->
            <div class="card border-0 shadow-sm wine-card mb-4" id="profile">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-user text-gold me-2"></i>
                        Profile Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="profileAccordion">
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9">
                                    <i class="fas fa-camera text-gold me-2"></i>
                                    How do I update my profile photo?
                                </button>
                            </h2>
                            <div id="collapse9" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>To update your profile photo:</p>
                                    <ol>
                                        <li>Go to Profile in the user menu</li>
                                        <li>Click "Add Photo" or "Change Photo"</li>
                                        <li>Select an image file (PNG, JPG, GIF, max 2MB)</li>
                                        <li>Click "Update Photo"</li>
                                        <li>Your new photo will appear immediately</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed wine-accordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10">
                                    <i class="fas fa-lock text-gold me-2"></i>
                                    How do I change my password?
                                </button>
                            </h2>
                            <div id="collapse10" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p>To change your password:</p>
                                    <ol>
                                        <li>Go to Profile in the user menu</li>
                                        <li>Scroll to "Update Password" section</li>
                                        <li>Enter your current password</li>
                                        <li>Enter your new password twice</li>
                                        <li>Click "Save" to update</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="card border-0 shadow-sm wine-card mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-headset text-gold me-2"></i>
                        Contact Support
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Need additional help? Contact our support team:</p>
                    
                    <div class="d-grid gap-2">
                        <a href="mailto:support@terravin.com" class="btn btn-outline-burgundy">
                            <i class="fas fa-envelope me-2"></i>Email Support
                        </a>
                        <a href="tel:+1234567890" class="btn btn-outline-burgundy">
                            <i class="fas fa-phone me-2"></i>Call Support
                        </a>
                        <a href="{{ route('chat.index') }}" class="btn btn-outline-gold">
                            <i class="fas fa-comments me-2"></i>Live Chat
                        </a>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-clock text-gold me-1"></i>
                            Support Hours: Mon-Fri 9AM-6PM
                        </small>
                    </div>
                </div>
            </div>

            <!-- FAQ Quick Links -->
            <div class="card border-0 shadow-sm wine-card">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold text-burgundy">
                        <i class="fas fa-lightbulb text-gold me-2"></i>
                        Quick Tips
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Use the search function to find specific wines
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Save your favorite wines for quick access
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Enable notifications for order updates
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Keep your profile information updated
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.wine-accordion {
    background: linear-gradient(135deg, rgba(200, 169, 126, 0.1) 0%, rgba(94, 15, 15, 0.05) 100%);
    border: 1px solid rgba(200, 169, 126, 0.2);
    color: var(--burgundy);
    font-weight: 600;
}

.wine-accordion:hover {
    background: linear-gradient(135deg, rgba(200, 169, 126, 0.2) 0%, rgba(94, 15, 15, 0.1) 100%);
}

.wine-accordion:not(.collapsed) {
    background: linear-gradient(135deg, var(--gold) 0%, var(--dark-gold) 100%);
    color: var(--burgundy);
    border-color: var(--gold);
}

.accordion-body {
    background: #fffbe9 !important;
    border-top: 1px solid rgba(200, 169, 126, 0.2);
    color: var(--burgundy) !important;
    padding: 1.25rem 1.5rem !important;
    font-size: 1rem;
}

.btn-outline-burgundy:hover {
    background-color: var(--burgundy);
    border-color: var(--burgundy);
    color: white;
}

.btn-outline-gold:hover {
    background-color: var(--gold);
    border-color: var(--gold);
    color: var(--burgundy);
}

/* Smooth scrolling for anchor links */
html {
    scroll-behavior: smooth;
}

/* Ensure sections are properly positioned for anchor links */
[id] {
    scroll-margin-top: 100px;
}

.solution-box {
    background: linear-gradient(90deg, #fffbe9 80%, #c8a97e22 100%);
    border-left: 5px solid var(--gold);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(200, 169, 126, 0.08);
    padding: 1rem 1.25rem;
    margin-top: 1rem;
}

.accordion-collapse.show, .collapse.show {
    display: block !important;
    height: auto !important;
    opacity: 1 !important;
    visibility: visible !important;
    overflow: visible !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                // Smooth scroll to the target element
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Add a subtle highlight effect
                targetElement.style.transition = 'box-shadow 0.3s ease';
                targetElement.style.boxShadow = '0 0 20px rgba(200, 169, 126, 0.3)';
                
                setTimeout(() => {
                    targetElement.style.boxShadow = '';
                }, 2000);
            }
        });
    });
});
</script>
@endsection 