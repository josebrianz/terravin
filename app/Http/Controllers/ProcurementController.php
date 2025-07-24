<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procurement;
use App\Models\User;
use Illuminate\Support\Str;

class ProcurementController extends Controller
{
    public function dashboard()
    {
        // Key metrics
        $totalProcurements = Procurement::count();
        $pendingProcurements = Procurement::pending()->count();
        $approvedProcurements = Procurement::approved()->count();
        $orderedProcurements = Procurement::ordered()->count();
        $receivedProcurements = Procurement::received()->count();
        $cancelledProcurements = Procurement::cancelled()->count();

        // Financial metrics
        $totalValue = Procurement::sum('total_amount');
        $pendingValue = Procurement::pending()->sum('total_amount');
        $approvedValue = Procurement::approved()->sum('total_amount');
        $orderedValue = Procurement::ordered()->sum('total_amount');

        // Recent procurements
        $recentProcurements = Procurement::with(['requester', 'approver'])
            ->latest()
            ->take(10)
            ->get();

        // Top suppliers
        $topSuppliers = Procurement::selectRaw('wholesaler_name, COUNT(*) as count, SUM(total_amount) as total_value')
            ->groupBy('wholesaler_name')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // Monthly procurement trend (last 6 months)
        $monthlyTrend = Procurement::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total_amount) as total_value')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Overdue procurements
        $overdueProcurements = Procurement::where('expected_delivery', '<', now())
            ->whereNotIn('status', ['received', 'cancelled'])
            ->with('requester')
            ->get();

        return view('procurement.dashboard', compact(
            'totalProcurements',
            'pendingProcurements',
            'approvedProcurements',
            'orderedProcurements',
            'receivedProcurements',
            'cancelledProcurements',
            'totalValue',
            'pendingValue',
            'approvedValue',
            'orderedValue',
            'recentProcurements',
            'topSuppliers',
            'monthlyTrend',
            'overdueProcurements'
        ));
    }

    public function index(Request $request)
    {
        $query = Procurement::with(['requester', 'approver']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by supplier (wholesaler_name)
        if ($request->filled('supplier')) {
            $query->where('wholesaler_name', 'like', '%' . $request->supplier . '%');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $procurements = $query->latest()->paginate(15);

        // Get all suppliers for dropdown
        $suppliers = User::where('role', 'Supplier')->orderBy('name')->get(['id', 'name', 'email']);

        return view('procurement.index', compact('procurements', 'suppliers'));
    }

    public function create()
    {
        $suppliers = \App\Models\User::where('role', 'Supplier')->get(['id', 'name', 'email']);
        $rawMaterials = \App\Models\SupplierRawMaterial::all();
        return view('procurement.create', compact('suppliers', 'rawMaterials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:users,id',
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0.01',
            'order_date' => 'nullable|date',
            'expected_delivery_date' => 'nullable|date|after:today',
        ]);

        // Get supplier information
        $supplier = User::findOrFail($request->supplier_id);

        // Check supplier's available stock for the selected raw material
        $rawMaterial = \App\Models\SupplierRawMaterial::where('user_id', $supplier->id)
            ->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($request->item_name))])
            ->first();
        $availableStock = $rawMaterial ? (is_numeric($rawMaterial->stock_level) ? (float)$rawMaterial->stock_level : (float)preg_replace('/[^\d.]/', '', $rawMaterial->stock_level)) : 0;
        if ($rawMaterial && $request->quantity > $availableStock) {
            return back()->withErrors(['quantity' => 'Requested quantity ('.$request->quantity.') exceeds supplier\'s available stock ('.$rawMaterial->stock_level.').'])->withInput();
        }

        // Debug logging
        \Log::info('Procurement creation:', [
            'supplier' => $supplier->name,
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_amount' => $request->quantity * $request->unit_price
        ]);

        $procurement = new Procurement();
        $procurement->item_name = $request->item_name;
        $procurement->description = $request->description;
        $procurement->wholesaler_name = $supplier->name; // Use supplier name as wholesaler name
        $procurement->wholesaler_email = $supplier->email;
        $procurement->quantity = $request->quantity;
        $procurement->unit_price = $request->unit_price;
        $procurement->order_date = $request->order_date;
        $procurement->expected_delivery = $request->expected_delivery_date;
        $procurement->po_number = 'PO-' . date('Y') . '-' . str_pad(Procurement::count() + 1, 4, '0', STR_PAD_LEFT);
        $procurement->total_amount = $request->quantity * $request->unit_price;
        $procurement->requested_by = auth()->id() ?? 1; // Default to user ID 1 if no auth
        $procurement->status = 'pending';
        $procurement->save();

        return redirect()->route('procurement.index')
            ->with('success', 'Procurement request created successfully.');
    }

    public function show(Procurement $procurement)
    {
        $procurement->load(['requester', 'approver']);
        return view('procurement.show', compact('procurement'));
    }

    public function edit(Procurement $procurement)
    {
        $users = User::all();
        return view('procurement.edit', compact('procurement', 'users'));
    }

    public function update(Request $request, Procurement $procurement)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'wholesaler_name' => 'required|string|max:255',
            'wholesaler_email' => 'nullable|email',
            'wholesaler_phone' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,ordered,received,cancelled',
            'order_date' => 'nullable|date',
            'expected_delivery' => 'nullable|date',
            'actual_delivery' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $procurement->update($request->all());
        $procurement->total_amount = $request->quantity * $request->unit_price;
        
        if ($request->status === 'approved' && !$procurement->approved_by) {
            $procurement->approved_by = auth()->id() ?? 1;
        }
        
        $procurement->save();

        return redirect()->route('procurement.index')
            ->with('success', 'Procurement updated successfully.');
    }

    public function destroy(Procurement $procurement)
    {
        $procurement->delete();
        return redirect()->route('procurement.index')
            ->with('success', 'Procurement deleted successfully.');
    }

    public function approve(Procurement $procurement)
    {
        $procurement->update([
            'status' => 'approved',
            'approved_by' => auth()->id() ?? 1,
        ]);

        return redirect()->back()->with('success', 'Procurement approved successfully.');
    }

    public function markAsOrdered(Procurement $procurement)
    {
        $procurement->update([
            'status' => 'ordered',
            'order_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Procurement marked as ordered.');
    }

    public function markAsReceived(Procurement $procurement)
    {
        $procurement->update([
            'status' => 'received',
            'actual_delivery' => now(),
        ]);

        \Log::info('Procurement markAsReceived', [
            'supplier_name' => $procurement->supplier_name,
            'item_name' => $procurement->item_name,
        ]);

        // Case-insensitive, trimmed supplier lookup
        $supplier = \App\Models\User::whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($procurement->supplier_name))])->first();
        \Log::info('Supplier lookup', [
            'supplier_found' => $supplier ? true : false,
            'supplier_id' => $supplier->id ?? null,
        ]);
        if ($supplier) {
            // Case-insensitive, trimmed raw material lookup
            $rawMaterial = \App\Models\SupplierRawMaterial::where('user_id', $supplier->id)
                ->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($procurement->item_name))])
                ->first();
            \Log::info('Raw material lookup', [
                'raw_material_found' => $rawMaterial ? true : false,
                'raw_material_id' => $rawMaterial->id ?? null,
                'current_stock_level' => $rawMaterial->stock_level ?? null,
            ]);
            if ($rawMaterial) {
                $currentStock = is_numeric($rawMaterial->stock_level) ? (float)$rawMaterial->stock_level : (float)preg_replace('/[^\d.]/', '', $rawMaterial->stock_level);
                $newStock = max(0, $currentStock - $procurement->quantity);
                \Log::info('Stock update', [
                    'currentStock' => $currentStock,
                    'quantity' => $procurement->quantity,
                    'newStock' => $newStock,
                ]);
                if (preg_match('/[a-zA-Z]+$/', $rawMaterial->stock_level, $matches)) {
                    $rawMaterial->stock_level = $newStock . ' ' . $matches[0];
                } else {
                    $rawMaterial->stock_level = $newStock;
                }
                $rawMaterial->save();
            }
        }

        return redirect()->back()->with('success', 'Procurement marked as received. Supplier inventory updated.');
    }
}
