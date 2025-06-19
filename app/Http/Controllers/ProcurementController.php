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
        $topSuppliers = Procurement::selectRaw('supplier_name, COUNT(*) as count, SUM(total_amount) as total_value')
            ->groupBy('supplier_name')
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

    public function index()
    {
        $procurements = Procurement::with(['requester', 'approver'])
            ->latest()
            ->paginate(15);

        return view('procurement.index', compact('procurements'));
    }

    public function create()
    {
        $users = User::all();
        return view('procurement.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'supplier_name' => 'required|string|max:255',
            'supplier_email' => 'nullable|email',
            'supplier_phone' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'expected_delivery' => 'nullable|date|after:today',
            'notes' => 'nullable|string',
        ]);

        $procurement = new Procurement($request->all());
        $procurement->po_number = 'PO-' . date('Y') . '-' . str_pad(Procurement::count() + 1, 4, '0', STR_PAD_LEFT);
        $procurement->total_amount = $request->quantity * $request->unit_price;
        $procurement->requested_by = auth()->id() ?? 1; // Default to user ID 1 if no auth
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
            'supplier_name' => 'required|string|max:255',
            'supplier_email' => 'nullable|email',
            'supplier_phone' => 'nullable|string',
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

        return redirect()->back()->with('success', 'Procurement marked as received.');
    }
}
