@extends('layouts.app')

@section('title', 'Upload Compliance Document')

@section('content')
<div class="container py-4 wine-theme-bg min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h4 class="fw-bold text-burgundy mb-0">Upload Compliance Document</h4>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('compliance-documents.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="type" class="form-label fw-bold">Document Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="certificate" {{ old('type') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                <option value="permit" {{ old('type') == 'permit' ? 'selected' : '' }}>Permit</option>
                                <option value="safety sheet" {{ old('type') == 'safety sheet' ? 'selected' : '' }}>Safety Data Sheet</option>
                                <option value="traceability" {{ old('type') == 'traceability' ? 'selected' : '' }}>Traceability Record</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Document Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label fw-bold">File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="valid" {{ old('status') == 'valid' ? 'selected' : '' }}>Valid</option>
                                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label fw-bold">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('compliance-documents.index') }}" class="btn btn-outline-burgundy me-2">Cancel</a>
                            <button type="submit" class="btn btn-gold">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 