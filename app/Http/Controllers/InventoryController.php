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
            'name'  => 'required|string|max:255',
            'sku'  => 'required|string|max:255|unique:inventories',
            'quantity'   => 'required|integer|min:0',
            'unit_price'      => 'required|numeric|min:0',
            'location'   => 'nullable|string|max:255',
            'images.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('inventory_images', 'public');
            }
        }
        $validated['images'] = $imagePaths;

        // Always set item_code to sku
        $validated['item_code'] = $validated['sku'];

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
            'name'  => 'required|string|max:255',
            'sku'  => 'required|string|max:255|unique:inventories,sku,' . $inventory->id,
            'quantity'   => 'required|integer|min:0',
            'unit_price'      => 'required|numeric|min:0',
            'location'   => 'nullable|string|max:255',
            'images.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('inventory_images', 'public');
            }
            $validated['images'] = $imagePaths;
        } else {
            $validated['images'] = $inventory->images ?? [];
        }

        $inventory->update($validated);

        return redirect()->route('inventory.index')->with('success', 'Item updated successfully!');
    }

    // To delete item
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Item deleted.');
    }

    public function searchCatalog(Request $request)
    {
        $q = $request->input('q');
        $items = \App\Models\Inventory::where('is_active', true)
            ->where('quantity', '>', 0)
            ->where('name', 'like', "%$q%")
            ->orderBy('name')
            ->limit(8)
            ->get(['id', 'name', 'images', 'unit_price']);
        $results = $items->map(function($item) {
            $img = null;
            if (is_array($item->images) && count($item->images) > 0) {
                $img = (str_starts_with($item->images[0], 'inventory_images/') ? asset('storage/' . $item->images[0]) : asset('wine_images/' . $item->images[0]));
            }
            return [
                'id' => $item->id,
                'name' => $item->name,
                'image' => $img,
                'unit_price' => $item->unit_price,
            ];
        });
        return response()->json($results);
    }
}
