<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function showApplicationForm()
    {
        return view('vendor.apply');
    }

    public function submitVendorApplication(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'years_in_operation' => 'required|integer|min:0',
            'employees' => 'required|integer|min:1',
            'turnover' => 'required|numeric|min:0',
            'material' => 'required|string|max:255',
            'clients' => 'nullable|string|max:255',
            'certification_organic' => 'nullable|in:true,false',
            'certification_iso' => 'nullable|in:true,false',
            'regulatory_compliance' => 'required|in:true',
            'is_registered' => 'required|boolean',
            'has_license' => 'required|boolean',
            'application_pdf' => 'required|file|mimes:pdf|max:10240',
        ]);

        // Store the uploaded PDF file and get the storage path
        if ($request->hasFile('application_pdf')) {
            $pdfPath = $request->file('application_pdf')->store('vendor_documents', 'public');
        } else {
            return back()->withErrors(['application_pdf' => 'PDF file upload failed.']);
        }

        Vendor::create([
            'user_id' => Auth::id(),
            'company_name' => $validated['company_name'],
            'contact_person' => $validated['contact_person'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'years_in_operation' => $validated['years_in_operation'],
            'employees' => $validated['employees'],
            'turnover' => $validated['turnover'],
            'material' => $validated['material'],
            'clients' => $validated['clients'] ?? null,
            'certification_organic' => $validated['certification_organic'] === 'true',
            'certification_iso' => $validated['certification_iso'] === 'true',
            'regulatory_compliance' => $validated['regulatory_compliance'] === 'true',
            'is_registered' => $validated['is_registered'],
            'has_license' => $validated['has_license'],
            'application_pdf' => $pdfPath,  // <--- Correct column name here
            'validation_status' => 'pending',
        ]);

        return redirect()->route('vendor.waiting')->with('success', 'Application submitted successfully.');
    }
}
