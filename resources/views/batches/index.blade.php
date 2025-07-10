@extends('layouts.app')

@section('title', 'Batch/Lot Tracking')

@section('content')
<div class="container py-4 wine-theme-bg min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-burgundy">Batch/Lot Tracking</h1>
        <a href="{{ route('batches.create') }}" class="btn btn-gold">Add Batch</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-cream">
                    <tr>
                        <th>Batch #</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Manufacture Date</th>
                        <th>Expiry Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batches as $batch)
                    <tr>
                        <td class="fw-bold">{{ $batch->batch_number }}</td>
                        <td>{{ $batch->product->name ?? '-' }}</td>
                        <td>{{ $batch->quantity }}</td>
                        <td>{{ $batch->manufacture_date->format('M d, Y') }}</td>
                        <td>{{ $batch->expiry_date ? $batch->expiry_date->format('M d, Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('batches.edit', $batch) }}" class="btn btn-sm btn-outline-burgundy">Edit</a>
                            <form action="{{ route('batches.destroy', $batch) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this batch?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No batches found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $batches->links() }}
    </div>
</div>
@endsection 