@extends('layout')

@section('title', 'Workforce Assignments')

@section('content')
<div class="container py-4">
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