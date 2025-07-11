@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Vendor Application Form</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/vendor/submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Company Name</label>
            <input type="text" name="companyName" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contact Person</label>
            <input type="text" name="contactPerson" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phoneNumber" class="form-control">
        </div>

        <div class="mb-3">
            <label>Years in Operation</label>
            <input type="number" name="yearsInOperation" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label>Number of Employees</label>
            <input type="number" name="numberOfEmployees" class="form-control" min="1">
        </div>

        <div class="mb-3">
            <label>Annual Turnover (USD)</label>
            <input type="number" name="annualTurnover" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Material Supplied</label>
            <input type="text" name="materialSupplied" class="form-control" placeholder="e.g. Grapes, Corks, Bottles" required>
        </div>

        <div class="mb-3">
            <label>Previous Clients</label>
            <input type="text" name="previousClients" class="form-control">
        </div>

        <div class="form-check mb-2">
            <input type="checkbox" name="hasOrganicCertification" class="form-check-input" value="true">
            <label class="form-check-label">Organic Certification</label>
        </div>

        <div class="form-check mb-2">
            <input type="checkbox" name="hasISO22000Certification" class="form-check-input" value="true">
            <label class="form-check-label">ISO 22000 Certification</label>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="compliantWithLocalRegulations" class="form-check-input" value="true" required>
            <label class="form-check-label">I confirm compliance with local regulations</label>
        </div>

        <button type="submit" class="btn btn-primary">Submit Application</button>
    </form>
</div>
@endsection
