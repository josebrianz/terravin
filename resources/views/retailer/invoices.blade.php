<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Invoices | Terravin Wines</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --terravin-maroon: #5e0f0f;
            --terravin-gold: #e0c68a;
            --terravin-light: #f8f6f3;
            --terravin-dark-gold: #a67c00;
        }
        body {
            background: var(--terravin-light);
            font-family: 'Georgia', serif;
        }
        .winery-header {
            color: var(--terravin-maroon);
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative;
            padding-bottom: 1rem;
            font-size: 2.5rem;
            text-shadow: 2px 2px 0 var(--terravin-gold), 0 2px 8px rgba(94, 15, 15, 0.08);
            margin-top: 1.5rem;
            margin-bottom: 2rem;
        }
        .winery-header:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, var(--terravin-maroon), var(--terravin-gold), var(--terravin-maroon));
        }
        .winery-logo {
            display: block;
            margin: 0 auto 1.5rem auto;
            max-width: 120px;
            height: auto;
            border-radius: 50%;
            border: 3px solid var(--terravin-gold);
            background: #fff;
            box-shadow: 0 2px 8px rgba(94, 15, 15, 0.1);
        }
        .card {
            border: 1px solid var(--terravin-gold);
            box-shadow: 0 4px 12px rgba(94, 15, 15, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, var(--terravin-maroon), #4a0c0c);
            color: white;
            padding: 1.5rem;
            border-bottom: 2px solid var(--terravin-gold);
        }
        .table thead {
            background: var(--terravin-gold);
            color: var(--terravin-maroon);
        }
        .table th {
            color: var(--terravin-maroon);
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .table-bordered > :not(caption) > * > * {
            border-color: rgba(224, 198, 138, 0.3);
        }
        .badge-paid {
            background-color: var(--terravin-gold) !important;
            color: var(--terravin-maroon) !important;
            font-weight: bold;
        }
        .badge-overdue {
            background-color: var(--terravin-maroon) !important;
            color: white !important;
            font-weight: bold;
        }
        .badge-pending {
            background-color: #fff3cd !important;
            color: var(--terravin-maroon) !important;
            font-weight: bold;
        }
        .btn-terravin {
            background: var(--terravin-maroon);
            color: white;
            border: none;
            transition: all 0.3s ease;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
        }
        .btn-terravin:hover, .btn-terravin:focus {
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
        .btn-outline-terravin:hover, .btn-outline-terravin:focus {
            background: var(--terravin-gold);
            color: var(--terravin-maroon);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .alert-terravin {
            background: rgba(224, 198, 138, 0.2);
            color: var(--terravin-maroon);
            border-color: var(--terravin-gold);
            border-left: 4px solid var(--terravin-maroon);
        }
        .invoice-amount {
            color: var(--terravin-maroon);
            font-weight: bold;
            font-size: 1.1rem;
        }
        .status-icon {
            margin-right: 6px;
        }
        .pagination .page-item.active .page-link {
            background-color: var(--terravin-maroon);
            border-color: var(--terravin-maroon);
        }
        .pagination .page-link {
            color: var(--terravin-maroon);
        }
        .filter-section {
            background: rgba(224, 198, 138, 0.1);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px dashed var(--terravin-gold);
        }
        .total-summary {
            background: rgba(224, 198, 138, 0.1);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1.5rem;
            border-left: 4px solid var(--terravin-maroon);
        }
        .action-btns .btn {
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
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
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="card">
                <div class="card-header text-center">
                    <div class="mb-2">
                        <i class="fas fa-wine-bottle wine-icon" style="color: var(--terravin-gold); font-size: 3.5rem;"></i>
                    </div>
                    <h1 class="winery-header d-flex align-items-center justify-content-center" style="gap: 0.75rem;">
                        <i class="fas fa-file-invoice" style="color: var(--terravin-gold); font-size: 2rem;"></i>
                        <span>My Invoices</span>
                    </h1>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="filter-section mb-4">
                        <form action="" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="paid">Paid</option>
                                    <option value="pending">Pending</option>
                                    <option value="overdue">Overdue</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                            <div class="col-md-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-terravin me-2">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <button type="reset" class="btn btn-outline-terravin">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>

                    @if($invoices->count() > 0)
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Invoice #</th>
                                        <th>Order #</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Issued At</th>
                                        <th>Due At</th>
                                        <th>Paid At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $invoice)
                                    <tr>
                                        <td data-label="Invoice #">{{ $invoice->id }}</td>
                                        <td data-label="Order #">{{ $invoice->order_id }}</td>
                                        <td data-label="Amount" class="invoice-amount">UGX {{ number_format($invoice->amount, 0, '.', ',') }}</td>
                                        <td data-label="Status">
                                            @if($invoice->status === 'paid')
                                                <span class="badge badge-paid rounded-pill">
                                                    <i class="fas fa-check-circle status-icon"></i> Paid
                                                </span>
                                            @elseif($invoice->status === 'overdue')
                                                <span class="badge badge-overdue rounded-pill">
                                                    <i class="fas fa-exclamation-circle status-icon"></i> Overdue
                                                </span>
                                            @else
                                                <span class="badge badge-pending rounded-pill">
                                                    <i class="fas fa-clock status-icon"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td data-label="Issued At">{{ $invoice->issued_at ? $invoice->issued_at->format('M d, Y') : '-' }}</td>
                                        <td data-label="Due At">
                                            @if($invoice->due_at)
                                                @if($invoice->due_at->isPast() && $invoice->status !== 'paid')
                                                    <span class="text-danger">{{ $invoice->due_at->format('M d, Y') }}</span>
                                                @else
                                                    {{ $invoice->due_at->format('M d, Y') }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td data-label="Paid At">{{ $invoice->paid_at ? $invoice->paid_at->format('M d, Y') : '-' }}</td>
                                        <td data-label="Actions" class="action-btns">
                                            <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-outline-terravin" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('invoices.download', $invoice->id) }}" class="btn btn-sm btn-outline-terravin" title="Download PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @if($invoice->status !== 'paid')
                                                <a href="{{ route('payment.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-sm btn-terravin" title="Pay Now">
                                                    <i class="fas fa-credit-card"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Section -->
                        <div class="total-summary">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between">
                                        <span>Total Invoices:</span>
                                        <strong>{{ $invoices->total() }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between">
                                        <span>Total Amount:</span>
                                        <strong>UGX {{ number_format($invoices->sum('amount'), 0, '.', ',') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between">
                                        <span>Total Paid:</span>
                                        <strong>UGX {{ number_format($invoices->where('status', 'paid')->sum('amount'), 0, '.', ',') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $invoices->links() }}
                        </div>
                    @else
                        <div class="alert alert-terravin text-center py-4">
                            <i class="fas fa-file-invoice fa-2x mb-3" style="color:var(--terravin-gold);"></i>
                            <h4 class="mb-3">No Invoices Found</h4>
                            <p class="mb-0">You don't have any invoices yet. When you place orders, your invoices will appear here.</p>
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('retailer.dashboard') }}" class="btn btn-outline-terravin">
                            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                        @if($invoices->count() > 0)
                            <a href="{{ route('invoices.export') }}" class="btn btn-terravin ms-2">
                                <i class="fas fa-file-export me-2"></i> Export to Excel
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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

    // Make the reset button functional
    document.addEventListener('DOMContentLoaded', function() {
        const resetBtn = document.querySelector('button[type="reset"]');
        const filterForm = resetBtn.closest('form');
        resetBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Clear all fields
            filterForm.reset();
            // Remove query params and reload page
            window.location = window.location.pathname;
        });
    });
</script>
</body>
</html>