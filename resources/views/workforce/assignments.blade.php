@extends('layout')

@section('title', 'Workforce Assignments')

@section('content')
<div class="wine-top-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-2">
                <a class="wine-brand" href="{{ route('workforce.dashboard') }}">
                    <i class="fas fa-wine-bottle"></i> Terravin
                </a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid py-4">
    <h1 class="mb-4">Workforce Assignments</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Workforce Name</th>
                <th>Role</th>
                <th>Supply Centre</th>
                <th>Location</th>
                <th>Assigned Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assignments as $assignment)
                <tr>
                    <td>{{ $assignment['workforce']->name }}</td>
                    <td>{{ $assignment['workforce']->role }}</td>
                    <td>{{ $assignment['centre']->name }}</td>
                    <td>{{ $assignment['centre']->location }}</td>
                    <td>{{ \Carbon\Carbon::parse($assignment['assigned_at'])->format('M d, Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('workforce.unassign') }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="workforce_id" value="{{ $assignment['workforce']->id }}">
                            <input type="hidden" name="supply_centre_id" value="{{ $assignment['centre']->id }}">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Unassign</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No assignments found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('workforce.dashboard') }}" class="btn btn-secondary mt-3">Back to Workforce Dashboard</a>
</div>
@endsection

@push('styles')
<style>
:root {
    --burgundy: #5e0f0f;
    --gold: #c8a97e;
    --cream: #f5f0e6;
    --light-burgundy: #8b1a1a;
}
.wine-top-bar {
    background: linear-gradient(135deg, var(--burgundy) 0%, var(--light-burgundy) 100%);
    color: white;
    padding: 0.75rem 0;
    box-shadow: 0 2px 10px rgba(94, 15, 15, 0.2);
    position: sticky;
    top: 0;
    z-index: 1000;
}
.wine-brand {
    color: var(--gold);
    text-decoration: none;
    font-size: 1.5rem;
    font-weight: 600;
    letter-spacing: 2px;
    font-family: 'Playfair Display', serif;
    transition: color 0.3s ease;
}
.wine-brand:hover {
    color: white;
    text-decoration: none;
}
</style>
@endpush 