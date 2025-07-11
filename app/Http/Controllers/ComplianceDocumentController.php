<?php

namespace App\Http\Controllers;

use App\Models\ComplianceDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplianceDocumentController extends Controller
{
    public function index()
    {
        $documents = ComplianceDocument::latest()->paginate(15);
        return view('compliance_documents.index', compact('documents'));
    }

    public function create()
    {
        return view('compliance_documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'name' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx',
            'status' => 'nullable|string',
            'expiry_date' => 'nullable|date',
        ]);
        $path = $request->file('file')->store('compliance_documents');
        $doc = ComplianceDocument::create([
            'type' => $validated['type'],
            'name' => $validated['name'],
            'file_path' => $path,
            'status' => $validated['status'] ?? 'valid',
            'expiry_date' => $validated['expiry_date'] ?? null,
        ]);
        return redirect()->route('compliance-documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function show(ComplianceDocument $compliance_document)
    {
        return Storage::download($compliance_document->file_path, $compliance_document->name);
    }

    public function destroy(ComplianceDocument $compliance_document)
    {
        Storage::delete($compliance_document->file_path);
        $compliance_document->delete();
        return redirect()->route('compliance-documents.index')->with('success', 'Document deleted successfully.');
    }
}
