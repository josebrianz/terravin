<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | TERRAVIN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .checkout-container {
            max-width: 700px;
            margin: 90px auto 0 auto;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            padding: 2.5rem 2rem 2rem 2rem;
        }
        .checkout-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--burgundy);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .checkout-summary th, .checkout-summary td {
            vertical-align: middle;
            text-align: center;
        }
        .checkout-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: var(--border-radius);
            border: 2px solid var(--gold);
        }
        .checkout-total {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--burgundy);
        }
        .place-order-btn {
            background: var(--burgundy);
            color: white;
            border: none;
            padding: 0.8rem 2.2rem;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        .place-order-btn:hover {
            background: var(--light-burgundy);
        }
        .empty-checkout {
            text-align: center;
            color: #888;
            margin: 3rem 0;
        }
        .empty-checkout i {
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
        @media (max-width: 768px) {
            .checkout-container {
                padding: 1.2rem 0.5rem 1.5rem 0.5rem;
            }
            .checkout-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div class="checkout-title"><i class="fas fa-credit-card"></i> Checkout</div>
        @if($cartItems->count() > 0)
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <table class="table checkout-summary align-middle mb-4">
                <thead>
                    <tr>
                        <th></th>
                        <th>Wine</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cartItems as $item)
                        @if($item->inventory)
                            @php $subtotal = $item->inventory->unit_price * $item->quantity; $total += $subtotal; @endphp
                            <tr>
                                <td>
                                    <img src="{{ $item->inventory->images && count($item->inventory->images) > 0 ? asset('storage/' . $item->inventory->images[0]) : 'https://via.placeholder.com/50x50?text=Wine' }}" class="checkout-image" alt="{{ $item->inventory->name }}">
                                </td>
                                <td>{{ $item->inventory->name }}</td>
                                <td>${{ number_format($item->inventory->unit_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($subtotal, 2) }}</td>
                            </tr>
                        @else
                            <tr class="table-danger">
                                <td colspan="5" class="text-danger text-center">
                                    This product is no longer available.
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="checkout-total mb-4">Total: ${{ number_format($total, 2) }}</div>
            <div class="mb-3">
                <label for="retailer_id" class="form-label">Select Retailer</label>
                <select name="retailer_id" id="retailer_id" class="form-control" required>
                    <option value="">-- Select Retailer --</option>
                    @foreach($retailers as $retailer)
                        <option value="{{ $retailer->id }}">{{ $retailer->name }} ({{ $retailer->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="shipping_address" class="form-label">Shipping Address</label>
                <textarea name="shipping_address" id="shipping_address" class="form-control" rows="2" required></textarea>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Order Notes (optional)</label>
                <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">Select a payment method</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                    <option value="Mobile Money">Mobile Money</option>
                    <option value="Card">Card</option>
                </select>
            </div>
            <button type="submit" class="place-order-btn">Place Order</button>
        </form>
        @else
        <div class="empty-checkout">
            <i class="fas fa-shopping-cart"></i>
            <div>Your cart is empty.</div>
            <a href="{{ route('customer.products') }}" class="shop-link"><i class="fas fa-plus"></i> Shop Wines</a>
        </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 