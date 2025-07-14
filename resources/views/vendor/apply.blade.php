@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Vendor Application Form</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your submission:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vendor.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="contact_person" class="form-label">Contact Person</label>
            <input type="text" name="contact_person" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Business Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="years_in_operation" class="form-label">Years in Operation</label>
            <input type="number" name="years_in_operation" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label for="employees" class="form-label">Number of Employees</label>
            <input type="number" name="employees" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label for="turnover" class="form-label">Annual Turnover (USD)</label>
            <input type="number" step="0.01" name="turnover" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="material" class="form-label">Materials Supplied</label>
            <input type="text" name="material" class="form-control" placeholder="e.g. Grapes, Bottles, Corks" required>
        </div>

        <div class="mb-3">
            <label for="clients" class="form-label">Previous Clients</label>
            <input type="text" name="clients" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Certifications</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="certification_organic" value="1" id="organicCert">
                <label class="form-check-label" for="organicCert">Organic Certified</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="certification_iso" value="1" id="isoCert">
                <label class="form-check-label" for="isoCert">ISO 22000 Certified</label>
            </div>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="regulatory_compliance" id="regulatoryCompliance" required>
            <label class="form-check-label" for="regulatoryCompliance">
                I confirm compliance with local regulations
            </label>
        </div>

        <div class="mb-4">
            <label for="application_pdf" class="form-label">Upload Application PDF</label>
            <input type="file" name="application_pdf" class="form-control" accept="application/pdf" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection
