@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="page-header bg-white shadow rounded-3 px-4 py-3 mb-4 d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div>
            <h1 class="page-title mb-1 fw-bold" style="font-family: 'Playfair Display', serif; color: var(--burgundy); font-size: 2.2rem; letter-spacing: 1px;">
                <i class="fas fa-file-signature me-2 text-gold"></i>
                Vendor Application Form
            </h1>
            <span class="text-muted small">Apply to become a trusted Terravin vendor partner</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your submission:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $err)
                    <li>• {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('vendor.submit') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3 shadow-sm p-4">
        @csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Company Name</label><input type="text" name="company_name" class="form-control" required value="{{ old('company_name') }}"></div>
            <div class="col-md-6"><label class="form-label">Contact Person</label><input type="text" name="contact_person" class="form-control" required value="{{ old('contact_person') }}"></div>
            <div class="col-md-6"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" required value="{{ old('phone') }}"></div>
            <div class="col-md-6"><label class="form-label">Business Email</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}"></div>
            <div class="col-md-6"><label class="form-label">Years in Operation</label><input type="number" name="years_in_operation" class="form-control" required value="{{ old('years_in_operation') }}"></div>
            <div class="col-md-6"><label class="form-label">Number of Employees</label><input type="number" name="employees" class="form-control" required value="{{ old('employees') }}"></div>
            <div class="col-md-6"><label class="form-label">Annual Turnover</label><input type="number" step="0.01" name="turnover" class="form-control" required value="{{ old('turnover') }}"></div>
            <div class="col-md-6"><label class="form-label">Primary Materials</label><input type="text" name="material" class="form-control" required value="{{ old('material') }}"></div>
            <div class="col-md-12"><label class="form-label">Previous Clients</label><input type="text" name="clients" class="form-control" value="{{ old('clients') }}"></div>
            
            <div class="col-md-12">
                <label class="form-label">Company Address</label>
                <input type="text" name="address" class="form-control" required value="{{ old('address') }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">Are you a registered company?</label><br>
                <input type="radio" name="is_registered" value="1" {{ old('is_registered') == '1' ? 'checked' : '' }} required> Yes
                <input type="radio" name="is_registered" value="0" {{ old('is_registered') == '0' ? 'checked' : '' }}> No
            </div>

            <div class="col-md-12">
                <label class="form-label">Do you have a valid business license?</label><br>
                <input type="radio" name="has_license" value="1" {{ old('has_license') == '1' ? 'checked' : '' }} required> Yes
                <input type="radio" name="has_license" value="0" {{ old('has_license') == '0' ? 'checked' : '' }}> No
            </div>

            <div class="col-md-12">
                <label class="form-label">Certifications</label><br>
                <input type="hidden" name="certification_organic" value="false">
                <input type="checkbox" name="certification_organic" value="true" {{ old('certification_organic') === 'true' ? 'checked' : '' }}> Organic Certified<br>
                <input type="hidden" name="certification_iso" value="false">
                <input type="checkbox" name="certification_iso" value="true" {{ old('certification_iso') === 'true' ? 'checked' : '' }}> ISO Certified
            </div>

            <div class="col-md-12">
                <div class="form-check mb-2">
                    <input type="hidden" name="regulatory_compliance" value="false">
                    <input class="form-check-input" type="checkbox" name="regulatory_compliance" value="true" {{ old('regulatory_compliance') ? 'checked' : '' }} required>
                    <label class="form-check-label">I comply with industry regulations.</label>
                </div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Attach Supporting Certificates (PDF only)</label>
                <input type="file" name="application_pdf" class="form-control" accept="application/pdf" required>
            </div>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-burgundy px-5 py-2">Submit Application</button>
        </div>
    </form>
</div>
@endsection
