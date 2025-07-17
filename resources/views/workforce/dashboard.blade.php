@extends('layout')

@section('title', 'Workforce Distribution Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header border-bottom pb-3 mb-4 d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="page-title mb-0 fw-bold text-burgundy" style="font-size: 2.5rem;">
                        <i class="fas fa-users me-2 text-gold"></i>
                        Workforce Distribution Dashboard
                    </h1>
                    
                </div>
                <div class="header-actions">
                    <form method="POST" action="{{ route('workforce.autoassign') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success" title="Auto-assign available workforce to empty supply centres">
                            <i class="fas fa-magic me-1"></i> Auto-Assign Workforce
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success w-75 mx-auto">{{ session('success') }}</div>
    @endif

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center stat-card h-100">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-burgundy mb-2"></i>
                    <h6 class="fw-bold">Total Workforce</h6>
                    <div class="display-6 fw-bold">{{ $total }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center stat-card h-100">
                <div class="card-body">
                    <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                    <h6 class="fw-bold">Assigned</h6>
                    <div class="display-6 fw-bold">{{ $assigned }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center stat-card h-100">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-2x text-info mb-2"></i>
                    <h6 class="fw-bold">Available</h6>
                    <div class="display-6 fw-bold">{{ $available }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Workforce Count by Supply Centre -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 fw-bold text-burgundy text-uppercase"><i class="fas fa-chart-bar text-gold me-2"></i> Workforce Count by Supply Centre</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Supply Centre</th>
                                <th>Location</th>
                                <th>Total Workers</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplyCentres as $centre)
                                <tr>
                                    <td>{{ $centre->name }}</td>
                                    <td>{{ $centre->location }}</td>
                                    <td>{{ $centre->workforces->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Forms -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 fw-bold text-burgundy text-uppercase"><i class="fas fa-user-plus text-gold me-2"></i> Add Workforce</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('workforce.store') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="role" class="form-control" placeholder="Role">
                        </div>
                        <div class="mb-3">
                            <select name="status" class="form-control" required>
                                <option value="available">Available</option>
                                <option value="assigned">Assigned</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="contact" class="form-control" placeholder="Contact">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Workforce</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 fw-bold text-burgundy text-uppercase"><i class="fas fa-building text-gold me-2"></i> Add Supply Centre</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('supplycentre.store') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="location" class="form-control" placeholder="Location">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Supply Centre</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Workforce -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 fw-bold text-burgundy text-uppercase"><i class="fas fa-link text-gold me-2"></i> Assign Workforce to Supply Centre</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('workforce.assign') }}" class="row g-3 align-items-end">
                        @csrf
                        <div class="col-md-4">
                            <select name="workforce_id" class="form-control" required>
                                <option value="">Select Workforce</option>
                                @foreach($workforces as $workforce)
                                    <option value="{{ $workforce->id }}">{{ $workforce->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="supply_centre_id" class="form-control" required>
                                <option value="">Select Supply Centre</option>
                                @foreach($supplyCentres as $centre)
                                    <option value="{{ $centre->id }}">{{ $centre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Workforce List -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 fw-bold text-burgundy text-uppercase"><i class="fas fa-list text-gold me-2"></i> Workforce List</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Contact</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workforces as $workforce)
                                <tr>
                                    <td>{{ $workforce->name }}</td>
                                    <td>{{ $workforce->role }}</td>
                                    <td>
                                        @if($workforce->status === 'assigned')
                                            <span class="badge bg-success">Assigned</span>
                                        @else
                                            <span class="badge bg-warning">Available</span>
                                        @endif
                                    </td>
                                    <td>{{ $workforce->contact }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('workforce.delete', $workforce->id) }}" onsubmit="return confirm('Delete this workforce?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Supply Centres -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="mb-0 fw-bold text-burgundy text-uppercase"><i class="fas fa-building text-gold me-2"></i> Supply Centres</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($supplyCentres as $centre)
                                <tr>
                                    <td>{{ $centre->name }}</td>
                                    <td>{{ $centre->location }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('supplycentre.delete', $centre->id) }}" onsubmit="return confirm('Delete this supply centre?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
}

.page-header {
    background: linear-gradient(135deg, var(--cream) 0%, #fff 100%);
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.1);
    padding: 1.5rem;
}

.text-burgundy {
    color: var(--burgundy) !important;
}

.text-gold {
    color: var(--gold) !important;
}

.card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 2px 8px rgba(94, 15, 15, 0.08);
}

.stat-card {
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.display-6 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--burgundy);
}

.badge {
    font-size: 0.875rem;
    padding: 0.5em 0.75em;
}
</style>
@endsection 