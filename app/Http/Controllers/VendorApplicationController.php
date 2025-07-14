<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class VendorApplicationController extends Controller
{
    public function create()
{
    return view('vendor.apply');
}

    public function submit(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'years_in_operation' => 'required|integer|min:0',
            'employees' => 'required|integer|min:1',
            'turnover' => 'required|numeric|min:0',
            'material' => 'required|string',
            'clients' => 'nullable|string',
            'certification_organic' => 'nullable|boolean',
            'certification_iso' => 'nullable|boolean',
            'regulatory_compliance' => 'required|accepted',
            'application_pdf' => 'required|mimes:pdf|max:2048',
        ]);

        $path = $request->file('application_pdf')->store('vendor_pdfs', 'public');

    $vendor = Vendor::create([
            'user_id' => Auth::id(),
            'company_name' => $request->company_name,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'years_in_operation' => $request->years_in_operation,
            'employees' => $request->employees,
            'turnover' => $request->turnover,
            'material' => $request->material,
            'clients' => $request->clients,
            'certification_organic' => $request->has('certification_organic'),
            'certification_iso' => $request->has('certification_iso'),
            'regulatory_compliance' => true,
            'validation_status' => 'pending',
            'application_pdf' => $path,
        ]);

// Prepare the data and file to send to Java microservice
$httpClient = new \GuzzleHttp\Client();

try {
    $response = $httpClient->post('http://localhost:8080/api/validate', [
        'multipart' => [
            [
                'name' => 'companyName',
                'contents' => $vendor->company_name,
            ],
            [
                'name' => 'contactPerson',
                'contents' => $vendor->contact_person,
            ],
            // Add other fields similarly...

            // PDF file upload
            [
                'name' => 'applicationPdf',
                'contents' => fopen(storage_path('app/public/' . $vendor->application_pdf), 'r'),
                'filename' => basename($vendor->application_pdf),
                'headers'  => [
                    'Content-Type' => 'application/pdf'
                ]
            ],
        ],
    ]);

    // You can handle $response if needed
} catch (\Exception $e) {
    \Log::error('Error sending vendor validation request: ' . $e->getMessage());
    // Optionally notify user/admin or retry logic
}

        return redirect()->route('vendor.waiting')->with('message', 'Application submitted successfully! Please wait for validation.');
    }

    public function waiting()
    {
        return view('vendor.waiting');
    }
}
