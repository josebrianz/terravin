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
            'email' => 'required|email',
            'years_in_operation' => 'required|integer|min:0',
            'employees' => 'required|integer|min:1',
            'turnover' => 'required|numeric|min:0',
            'material' => 'required|string',
            'clients' => 'nullable|string',
            'certification_organic' => 'required|in:true,false',
            'certification_iso' => 'required|in:true,false',
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

        // 🧠 THIS is now correctly placed inside the function
        $httpClient = new \GuzzleHttp\Client();

        try {
            $response = $httpClient->post('http://localhost:8082/api/validate', [
                'multipart' => [
                    ['name' => 'companyName', 'contents' => $vendor->company_name],
                    ['name' => 'contactPerson', 'contents' => $vendor->contact_person],
                    ['name' => 'phone', 'contents' => $vendor->phone],
                    ['name' => 'yearsInOperation', 'contents' => $vendor->years_in_operation],
                    ['name' => 'employees', 'contents' => $vendor->employees],
                    ['name' => 'turnover', 'contents' => $vendor->turnover],
                    ['name' => 'material', 'contents' => $vendor->material],
                    ['name' => 'clients', 'contents' => $vendor->clients ?? ''],
                    ['name' => 'certificationOrganic', 'contents' => $vendor->certification_organic ? 'true' : 'false'],
                    ['name' => 'certificationIso', 'contents' => $vendor->certification_iso ? 'true' : 'false'],
                    ['name' => 'regulatoryCompliance', 'contents' => 'true'],
                    [
                        'name' => 'applicationPdf',
                        'contents' => fopen(storage_path('app/public/' . $vendor->application_pdf), 'r'),
                        'filename' => basename($vendor->application_pdf),
                        'headers'  => ['Content-Type' => 'application/pdf']
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if ($data['status'] === 'approved') {
                $summaryPdfPath = $this->generateVendorSummaryPdf($vendor);

                \Mail::to('admin@example.com')->send(
                    new \App\Mail\VendorApprovalMail($vendor, $summaryPdfPath)
                );

                \App\Models\RoleApprovalRequest::create([
                    'user_id' => Auth::id(),
                    'requested_role' => 'Vendor',
                    'status' => 'pending',
                    'notes' => 'Auto-added after microservice approval',
                ]);

                return redirect()->route('vendor.waiting')->with('message',
                    'Application approved by system. Scheduled visit on ' . ($data['scheduledVisitDate'] ?? 'TBD')
                );
            } else {
                return redirect()->back()->withErrors(['Your application was not approved by the system.']);
            }

        } catch (\Exception $e) {
            \Log::error('Error contacting vendor validation server: ' . $e->getMessage());
            return redirect()->back()->withErrors(['There was a system error during validation. Please try again.']);
        }
    }

    private function generateVendorSummaryPdf($vendor) 
    {
        $pdf = \PDF::loadView('pdf.vendor_summary', ['vendor' => $vendor]);
        $filePath = 'vendor_summaries/summary_' . $vendor->id . '.pdf';
        Storage::disk('public')->put($filePath, $pdf->output());

        return storage_path('app/public/' . $filePath);
    }
}
