<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //  List of all inventory items
    public function index()
    {
        $items = Inventory::paginate(15);
        return view('inventory.index', compact('items'));
    }

    //  Showing form create a new item
    public function create()
    {
        return view('inventory.create');
    }

    //  Storing the new item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name'  => 'required|string|max:255',
            'item_code'  => 'required|string|max:255|unique:inventories',
            'quantity'   => 'required|integer|min:0',
            'price'      => 'required|numeric|min:0',
            'location'   => 'nullable|string|max:255',
        ]);

        Inventory::create($validated);

        return redirect()->route('inventory.index')->with('success', 'Item added successfully!');
    }

    // Showing the edit item form
    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', ['item' => $inventory]);
    }

    // To update an existing item
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'item_name'  => 'required|string|max:255',
            'item_code'  => 'required|string|max:255|unique:inventories,item_code,' . $inventory->id,
            'quantity'   => 'required|integer|min:0',
            'price'      => 'required|numeric|min:0',
            'location'   => 'nullable|string|max:255',
        ]);

        $inventory->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Item updated successfully!');
    }

    // To delete item
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Item deleted.');
    }
}
