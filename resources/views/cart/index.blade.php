<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | TERRAVIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --burgundy: #5e0f0f;
            --light-burgundy: #8b1a1a;
            --gold: #c8a97e;
            --cream: #f5f0e6;
            --light-cream: #f9f5ed;
            --dark-text: #2a2a2a;
            --gray: #e1e5e9;
            --light-gray: #f8f9fa;
            --shadow-sm: 0 2px 8px rgba(94, 15, 15, 0.08);
            --shadow-md: 0 4px 20px rgba(94, 15, 15, 0.12);
            --transition: all 0.3s ease;
            --border-radius: 12px;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-cream);
            color: var(--dark-text);
        }
        .cart-container {
            max-width: 900px;
            margin: 90px auto 0 auto;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .cart-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--burgundy);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .cart-table th, .cart-table td {
            vertical-align: middle;
            text-align: center;
        }
        .cart-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: var(--border-radius);
            border: 2px solid var(--gold);
        }
        .cart-remove {
            color: var(--burgundy);
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .cart-remove:hover {
            color: var(--light-burgundy);
        }
        .cart-total {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--burgundy);
        }
        .checkout-btn {
            background: var(--burgundy);
            color: white;
            border: none;
            padding: 0.8rem 2.2rem;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .checkout-btn:hover {
            background: var(--light-burgundy);
        }
        .empty-cart {
            text-align: center;
            color: #888;
            margin: 3rem 0;
        }
        .empty-cart i {
            font-size: 3rem;
            color: var(--burgundy);
            margin-bottom: 1rem;
        }
        .shop-link {
            color: var(--burgundy);
            font-weight: 500;
            text-decoration: none;
            margin-top: 1rem;
            display: inline-block;
        }
        .shop-link:hover {
            color: var(--gold);
            text-decoration: underline;
        }
        .btn-dashboard-wine {
            background: #5e0f0f !important;
            color: #c8a97e !important;
            border: 2px solid #c8a97e !important;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.15);
            padding: 0.7rem 1.7rem;
            font-size: 1.1rem;
            border-radius: 2rem;
            transition: background 0.2s, color 0.2s, border 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-dashboard-wine:hover, .btn-dashboard-wine:focus {
            background: #8b1a1a !important;
            color: #fff8e1 !important;
            border-color: #c8a97e !important;
            box-shadow: 0 4px 16px rgba(94, 15, 15, 0.22);
            text-decoration: none;
        }
        .btn-dashboard-wine i {
            color: #c8a97e !important;
            font-size: 1.2em;
        }
        @media (max-width: 768px) {
            .cart-container {
                padding: 1.2rem 0.5rem 1.5rem 0.5rem;
            }
            .cart-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="cart-title"><i class="fas fa-shopping-cart"></i> Your Cart</div>
            <a href="/customer/dashboard" class="btn btn-dashboard-wine" style="min-width: 160px;"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
        </div>
        @if($cartItems->count() > 0)
        <form id="cart-form">
            <table class="table cart-table align-middle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Wine</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cartItems as $item)
                        @php $subtotal = $item->wine->unit_price * $item->quantity; $total += $subtotal; @endphp
                        <tr data-id="{{ $item->id }}">
                            <td>
                                <img src="{{ $item->wine->images && count($item->wine->images) > 0 ? asset('storage/' . $item->wine->images[0]) : 'https://via.placeholder.com/70x70?text=Wine' }}" class="cart-image" alt="{{ $item->wine->name }}">
                            </td>
                            <td>{{ $item->wine->name }}</td>
                            <td>{{ format_usd($item->wine->unit_price) }}</td>
                            <td>
                                <input type="number" min="1" class="form-control text-center cart-qty" value="{{ $item->quantity }}" style="width:70px;display:inline-block;">
                            </td>
                            <td>{{ format_usd($subtotal) }}</td>
                            <td>
                                <button type="button" class="cart-remove" title="Remove"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="cart-total">Total: {{ format_usd($total) }}</div>
                <a href="{{ route('cart.checkout') }}" class="checkout-btn">Checkout</a>
            </div>
        </form>
        @else
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <div>Your cart is empty.</div>
            <a href="{{ route('customer.products') }}" class="shop-link"><i class="fas fa-plus"></i> Shop Wines</a>
        </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // AJAX for updating/removing cart items
        document.querySelectorAll('.cart-qty').forEach(function(input) {
            input.addEventListener('change', function() {
                var tr = this.closest('tr');
                var id = tr.getAttribute('data-id');
                var qty = this.value;
                fetch(`/cart/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ quantity: qty })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) location.reload();
                });
            });
        });
        document.querySelectorAll('.cart-remove').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var tr = this.closest('tr');
                var id = tr.getAttribute('data-id');
                fetch(`/cart/remove/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ _method: 'DELETE' })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) location.reload();
                });
            });
        });
    </script>
</body>
</html> 