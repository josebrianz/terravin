@extends('layout')

@section('title', 'Workforce Distribution Dashboard')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <!-- Terravin Wine Company Branding -->
        <div class="mb-2">
            <!-- Placeholder SVG logo, replace with real logo if available -->
            <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="30" cy="30" r="28" stroke="#800000" stroke-width="4" fill="#fff5f5"/>
                <ellipse cx="30" cy="38" rx="16" ry="8" fill="#800000"/>
                <rect x="25" y="12" width="10" height="22" rx="5" fill="#800000"/>
                <ellipse cx="30" cy="18" rx="5" ry="3" fill="#fff5f5"/>
            </svg>
        </div>
        <div class="mb-2">
            <span class="fs-5 fw-bold text-uppercase text-secondary" style="letter-spacing:2px;">Terravin Wine Company</span>
        </div>
        <h1 class="display-4 fw-bold">Workforce Distribution Dashboard</h1>
        <hr class="w-25 mx-auto"/>
        
        <!-- Help Link -->
        <div class="mt-3">
            <a href="{{ route('help.index') }}" class="btn btn-outline-primary" title="Get help and support">
                <i class="fas fa-question-circle me-2"></i>Help & Support
            </a>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success w-75 mx-auto">{{ session('success') }}</div>
    @endif
    <div class="row justify-content-center mb-5">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="bg-light rounded shadow-sm p-4 text-center h-100">
                <div class="mb-2">
                    <svg width="32" height="32" fill="#0d6efd" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M14 14s-1-1.5-6-1.5S2 14 2 14v1h12v-1z"/></svg>
                </div>
                <div class="fs-5 text-secondary">Total Workforce</div>
                <div class="display-6 fw-bold text-primary">{{ $total }}</div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="bg-light rounded shadow-sm p-4 text-center h-100">
                <div class="mb-2">
                    <svg width="32" height="32" fill="#198754" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M14 14s-1-1.5-6-1.5S2 14 2 14v1h12v-1z"/></svg>
                </div>
                <div class="fs-5 text-secondary">Assigned</div>
                <div class="display-6 fw-bold text-success">{{ $assigned }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-light rounded shadow-sm p-4 text-center h-100">
                <div class="mb-2">
                    <svg width="32" height="32" fill="#ffc107" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M14 14s-1-1.5-6-1.5S2 14 2 14v1h12v-1z"/></svg>
                </div>
                <div class="fs-5 text-secondary">Available</div>
                <div class="display-6 fw-bold text-warning">{{ $available }}</div>
            </div>
        </div>
    </div>

    <div class="mb-5">
        <h3 class="fw-bold border-bottom pb-2 mb-3">Workforce Count by Supply Centre</h3>
        <div class="bg-white rounded shadow-sm p-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
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

    <div class="row mb-5">
        <div class="col-md-6 mb-4 mb-md-0">
            <h3 class="fw-bold border-bottom pb-2 mb-3">Add Workforce</h3>
            <form method="POST" action="{{ route('workforce.store') }}" class="bg-white rounded shadow-sm p-4">
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
        <div class="col-md-6">
            <h3 class="fw-bold border-bottom pb-2 mb-3">Add Supply Centre</h3>
            <form method="POST" action="{{ route('supplycentre.store') }}" class="bg-white rounded shadow-sm p-4">
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

    <div class="mb-5">
        <h3 class="fw-bold border-bottom pb-2 mb-3">Assign Workforce to Supply Centre</h3>
        <form method="POST" action="{{ route('workforce.assign') }}" class="bg-white rounded shadow-sm p-4 row g-3 align-items-end">
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

    <div class="mb-5">
        <h3 class="fw-bold border-bottom pb-2 mb-3">Workforce List</h3>
        <div class="bg-white rounded shadow-sm p-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Contact</th>
                        <th>Assigned Supply Centres</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workforces as $workforce)
                        <tr>
                            <td>{{ $workforce->name }}</td>
                            <td>{{ $workforce->role }}</td>
                            <td>{{ $workforce->status }}</td>
                            <td>{{ $workforce->contact }}</td>
                            <td>
                                @if($workforce->supplyCentres->isNotEmpty())
                                    <ul class="mb-0 ps-3">
                                        @foreach($workforce->supplyCentres as $centre)
                                            <li class="mb-1">
                                                {{ $centre->name }} ({{ $centre->location }})
                                                <form method="POST" action="{{ route('workforce.unassign') }}" style="display:inline">
                                                    @csrf
                                                    <input type="hidden" name="workforce_id" value="{{ $workforce->id }}">
                                                    <input type="hidden" name="supply_centre_id" value="{{ $centre->id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-2">Unassign</button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Not assigned</span>
                                @endif
                            </td>
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

    <div class="mb-5">
        <h3 class="fw-bold border-bottom pb-2 mb-3">Supply Centres</h3>
        <div class="bg-white rounded shadow-sm p-4">
            <table class="table table-hover align-middle">
                <thead class="table-light">
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
@endsection 