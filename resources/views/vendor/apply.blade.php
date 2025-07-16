@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Vendor Application Form</h2>

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
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contact Person</label>
            <input type="text" name="contact_person" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Business Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Years in Operation</label>
            <input type="number" name="years_in_operation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Number of Employees</label>
            <input type="number" name="employees" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Annual Turnover</label>
            <input type="number" step="0.01" name="turnover" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Primary Materials</label>
            <input type="text" name="material" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Previous Clients</label>
            <input type="text" name="clients" class="form-control">
        </div>

        <div class="mb-3">
            <label>Certifications</label><br>
            <input type="checkbox" name="certification_organic"> Organic Certified <br>
            <input type="checkbox" name="certification_iso"> ISO Certified
        </div>

        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="regulatory_compliance" required>
            <label class="form-check-label">I comply with industry regulations.</label>
        </div>

        <div class="mb-4">
            <label>Attach Supporting Certificates (PDF only)</label>
            <input type="file" name="application_pdf" class="form-control" accept="application/pdf" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection
