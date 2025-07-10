<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Terravin Wines</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --terravin-maroon: #5e0f0f;
            --terravin-gold: #e0c68a;
            --terravin-light: #f8f6f3;
            --terravin-dark-gold: #a67c00;
            --terravin-light-gold: rgba(224, 198, 138, 0.1);
        }
        body {
            background-color: var(--terravin-light);
            font-family: 'Georgia', serif;
        }
        .page-header {
            color: var(--terravin-maroon);
            font-weight: 700;
            letter-spacing: 0.5px;
            position: relative;
            padding-bottom: 1rem;
            text-transform: uppercase;
        }
        .page-header:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--terravin-maroon), var(--terravin-gold));
        }
        .card {
            border: 1px solid var(--terravin-gold);
            box-shadow: 0 4px 12px rgba(94, 15, 15, 0.08);
            border-radius: 8px;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, var(--terravin-maroon), #4a0c0c);
            color: white;
            padding: 1rem 1.5rem;
            border-bottom: 2px solid var(--terravin-gold);
        }
        .table thead {
            background: var(--terravin-gold);
            color: var(--terravin-maroon);
        }
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .table-hover tbody tr:hover {
            background-color: var(--terravin-light-gold);
        }
        .badge-pending {
            background-color: #fff3cd !important;
            color: var(--terravin-maroon) !important;
        }
        .badge-processing {
            background-color: #cce5ff !important;
            color: var(--terravin-maroon) !important;
        }
        .badge-shipped {
            background-color: #d4edda !important;
            color: #155724 !important;
        }
        .badge-delivered {
            background-color: var(--terravin-gold) !important;
            color: var(--terravin-maroon) !important;
            font-weight: 600;
        }
        .badge-cancelled {
            background-color: #f8d7da !important;
            color: #721c24 !important;
        }
        .btn-terravin {
            background: var(--terravin-maroon);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-terravin:hover {
            background: var(--terravin-dark-gold);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-outline-terravin {
            border-color: var(--terravin-gold);
            color: var(--terravin-maroon);
            transition: all 0.3s ease;
        }
        .btn-outline-terravin:hover {
            background: var(--terravin-gold);
            color: var(--terravin-maroon);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .filter-section {
            background: var(--terravin-light-gold);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px dashed var(--terravin-gold);
        }
        .order-total {
            font-weight: 600;
            color: var(--terravin-maroon);
        }
        .pagination .page-item.active .page-link {
            background-color: var(--terravin-maroon);
            border-color: var(--terravin-maroon);
        }
        .pagination .page-link {
            color: var(--terravin-maroon);
        }
        .empty-state {
            padding: 3rem;
            text-align: center;
        }
        .empty-state-icon {
            font-size: 3rem;
            color: var(--terravin-gold);
            margin-bottom: 1rem;
        }
        .status-icon {
            margin-right: 6px;
        }
        @media (max-width: 768px) {
            .table-responsive {
                border: none;
            }
            .table thead {
                display: none;
            }
            .table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid var(--terravin-gold);
                border-radius: 8px;
            }
            .table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem;
                border-bottom: 1px solid rgba(224, 198, 138, 0.3);
            }
            .table td:before {
                content: attr(data-label);
                font-weight: bold;
                color: var(--terravin-maroon);
                margin-right: 1rem;
                text-transform: uppercase;
                font-size: 0.8rem;
            }
            .table td:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-header mb-0"><i class="fas fa-clipboard-list me-2"></i>My Orders</h1>
            <a href="#" class="btn btn-terravin">
                <i class="fas fa-plus me-1"></i> New Order
            </a>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="row g-3">
                <div class="col-md-8">
                    <form method="GET" class="row g-2">
                        <div class="col-md-4">
                            <label for="status" class="form-label">Order Status</label>
                            <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date">
                        </div>
                        <div class="col-md-4">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" class="form-control" id="to_date" name="to_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </form>
                </div>
                <div class="col-md-4 d-flex align-items-end justify-content-end gap-2">
                    <button type="submit" class="btn btn-terravin">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                    <button type="reset" class="btn btn-outline-terravin">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order History</h5>
                <div>
                    <a href="#" class="btn btn-sm btn-outline-terravin me-2">
                        <i class="fas fa-file-csv me-1"></i> Export CSV
                    </a>
                    <a href="#" class="btn btn-sm btn-outline-terravin">
                        <i class="fas fa-print me-1"></i> Print
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example Order 1 -->
                            <tr>
                                <td data-label="Order #">#TV-2025-0125</td>
                                <td data-label="Date">Jul 08, 2025</td>
                                <td data-label="Items">3</td>
                                <td data-label="Total" class="order-total">UGX 120,000</td>
                                <td data-label="Status">
                                    <span class="badge badge-pending rounded-pill">
                                        <i class="fas fa-clock status-icon"></i> Pending
                                    </span>
                                </td>
                                <td data-label="Actions">
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-receipt"></i> Invoice
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Example Order 2 -->
                            <tr>
                                <td data-label="Order #">#TV-2025-0124</td>
                                <td data-label="Date">Jul 05, 2025</td>
                                <td data-label="Items">5</td>
                                <td data-label="Total" class="order-total">UGX 185,500</td>
                                <td data-label="Status">
                                    <span class="badge badge-processing rounded-pill">
                                        <i class="fas fa-cog status-icon"></i> Processing
                                    </span>
                                </td>
                                <td data-label="Actions">
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-receipt"></i> Invoice
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Example Order 3 -->
                            <tr>
                                <td data-label="Order #">#TV-2025-0123</td>
                                <td data-label="Date">Jul 01, 2025</td>
                                <td data-label="Items">2</td>
                                <td data-label="Total" class="order-total">UGX 75,000</td>
                                <td data-label="Status">
                                    <span class="badge badge-shipped rounded-pill">
                                        <i class="fas fa-truck status-icon"></i> Shipped
                                    </span>
                                </td>
                                <td data-label="Actions">
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-receipt"></i> Invoice
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-map-marker-alt"></i> Track
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Example Order 4 -->
                            <tr>
                                <td data-label="Order #">#TV-2025-0122</td>
                                <td data-label="Date">Jun 28, 2025</td>
                                <td data-label="Items">4</td>
                                <td data-label="Total" class="order-total">UGX 210,000</td>
                                <td data-label="Status">
                                    <span class="badge badge-delivered rounded-pill">
                                        <i class="fas fa-check-circle status-icon"></i> Delivered
                                    </span>
                                </td>
                                <td data-label="Actions">
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-terravin">
                                            <i class="fas fa-receipt"></i> Invoice
                                        </a>
                                        <a href="#" class="btn btn-sm btn-terravin">
                                            <i class="fas fa-redo"></i> Reorder
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Empty State (uncomment when needed) -->
                            <!--
                            <tr>
                                <td colspan="6" class="text-center empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <h4 class="mb-3">No Orders Found</h4>
                                    <p class="mb-4">You haven't placed any orders yet. When you do, they'll appear here.</p>
                                    <a href="#" class="btn btn-terravin">
                                        <i class="fas fa-wine-bottle me-2"></i> Browse Our Wines
                                    </a>
                                </td>
                            </tr>
                            -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Total Orders</h5>
                        <h2 class="mb-0" style="color: var(--terravin-maroon);">4</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Total Spent</h5>
                        <h2 class="mb-0" style="color: var(--terravin-maroon);">UGX 590,500</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Last Order</h5>
                        <h2 class="mb-0" style="color: var(--terravin-maroon);">Jul 08, 2025</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <nav>
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set today's date as default for "To Date" filter
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('to_date').value = today;
            
            // Set status filter if it was selected
            const urlParams = new URLSearchParams(window.location.search);
            const statusParam = urlParams.get('status');
            if(statusParam) {
                document.getElementById('status').value = statusParam;
            }
        });
    </script>
</body>
</html>