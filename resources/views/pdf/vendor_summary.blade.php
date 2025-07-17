<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vendor Summary</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; line-height: 1.6; }
        .section { margin-bottom: 20px; }
        .section h2 { border-bottom: 1px solid #ccc; padding-bottom: 5px; }
    </style>
</head>
<body>
    <h1>Vendor Application Summary</h1>

    <div class="section">
        <h2>Company Details</h2>
        <p><strong>Company Name:</strong> {{ $vendor->company_name }}</p>
        <p><strong>Contact Person:</strong> {{ $vendor->contact_person }}</p>
        <p><strong>Email:</strong> {{ $vendor->email }}</p>
        <p><strong>Phone:</strong> {{ $vendor->phone }}</p>
    </div>

    <div class="section">
        <h2>Operational Info</h2>
        <p><strong>Years in Operation:</strong> {{ $vendor->years_in_operation }}</p>
        <p><strong>Employees:</strong> {{ $vendor->employees }}</p>
        <p><strong>Turnover:</strong> {{ $vendor->turnover }}</p>
        <p><strong>Material:</strong> {{ $vendor->material }}</p>
        <p><strong>Clients:</strong> {{ $vendor->clients }}</p>
    </div>

    <div class="section">
        <h2>Certifications</h2>
        <p><strong>Organic:</strong> {{ $vendor->certification_organic ? 'Yes' : 'No' }}</p>
        <p><strong>ISO:</strong> {{ $vendor->certification_iso ? 'Yes' : 'No' }}</p>
        <p><strong>Compliant:</strong> {{ $vendor->regulatory_compliance ? 'Yes' : 'No' }}</p>
    </div>

    <p>Generated on {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
</body>
</html>
