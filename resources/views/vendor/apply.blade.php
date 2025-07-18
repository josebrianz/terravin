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
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="contact_person">Contact Person</label>
            <input type="text" name="contact_person" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email">Business Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="years_in_operation">Years in Operation</label>
            <input type="number" name="years_in_operation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="employees">Number of Employees</label>
            <input type="number" name="employees" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="turnover">Annual Turnover</label>
            <input type="number" step="0.01" name="turnover" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="material">Primary Materials</label>
            <input type="text" name="material" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="clients">Previous Clients</label>
            <input type="text" name="clients" class="form-control">
        </div>

        <div class="mb-3">
            <label>Certifications</label><br>

            <!-- Hidden fallback ensures value is always sent -->
            <input type="hidden" name="certification_organic" value="false">
            <input type="checkbox" name="certification_organic" value="true"> Organic Certified <br>

            <input type="hidden" name="certification_iso" value="false">
            <input type="checkbox" name="certification_iso" value="true"> ISO Certified
        </div>

        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" name="regulatory_compliance" value="true" required>
            <label class="form-check-label">I comply with industry regulations.</label>
        </div>

        <div class="mb-4">
            <label for="application_pdf">Attach Supporting Certificates (PDF only)</label>
            <input type="file" name="application_pdf" class="form-control" accept="application/pdf" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection
