<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Inventory;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('product')->latest()->paginate(15);
        return view('batches.index', compact('batches'));
    }

    public function create()
    {
        $products = Inventory::all();
        return view('batches.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_number' => 'required|string|unique:batches',
            'product_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:0',
            'manufacture_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:manufacture_date',
        ]);
        Batch::create($validated);
        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function edit(Batch $batch)
    {
        $products = Inventory::all();
        return view('batches.edit', compact('batch', 'products'));
    }

    public function update(Request $request, Batch $batch)
    {
        $validated = $request->validate([
            'batch_number' => 'required|string|unique:batches,batch_number,' . $batch->id,
            'product_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:0',
            'manufacture_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:manufacture_date',
        ]);
        $batch->update($validated);
        return redirect()->route('batches.index')->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }
}
