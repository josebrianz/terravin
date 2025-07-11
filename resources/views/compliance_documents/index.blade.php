@extends('layouts.app')

@section('title', 'Compliance Documents')

@section('content')
<div class="container py-4 wine-theme-bg min-vh-100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-burgundy">Compliance Documents</h1>
        <a href="{{ route('compliance-documents.create') }}" class="btn btn-gold">Upload Document</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-cream">
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Expiry Date</th>
                        <th>Download</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                    <tr>
                        <td>{{ ucfirst($doc->type) }}</td>
                        <td>{{ $doc->name }}</td>
                        <td><span class="badge {{ $doc->status === 'valid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($doc->status) }}</span></td>
                        <td>{{ $doc->expiry_date ? $doc->expiry_date->format('M d, Y') : '-' }}</td>
                        <td>
                            <a href="{{ route('compliance-documents.show', $doc) }}" class="btn btn-sm btn-outline-gold">Download</a>
                        </td>
                        <td>
                            <form action="{{ route('compliance-documents.destroy', $doc) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this document?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No compliance documents found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        {{ $documents->links() }}
    </div>
</div>
@endsection 