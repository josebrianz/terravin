<?php

namespace App\Http\Controllers;

use App\Models\Workforce;
use App\Models\SupplyCentre;
use Illuminate\Http\Request;

class WorkforceDashboardController extends Controller
{
    public function index()
    {
        $workforces = Workforce::with('supplyCentres')->get();
        $supplyCentres = SupplyCentre::all();

        $total = $workforces->count();
        $assigned = $workforces->filter(fn($w) => $w->supplyCentres->isNotEmpty())->count();
        $available = $total - $assigned;

        return view('workforce.dashboard', compact('workforces', 'supplyCentres', 'total', 'assigned', 'available'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'workforce_id' => 'required|exists:workforces,id',
            'supply_centre_id' => 'required|exists:supply_centres,id',
        ]);
        $workforce = Workforce::findOrFail($request->workforce_id);
        $workforce->supplyCentres()->syncWithoutDetaching([$request->supply_centre_id => ['assigned_at' => now()]]);
        return redirect()->route('workforce.dashboard')->with('success', 'Workforce assigned successfully.');
    }

    public function unassign(Request $request)
    {
        $request->validate([
            'workforce_id' => 'required|exists:workforces,id',
            'supply_centre_id' => 'required|exists:supply_centres,id',
        ]);
        $workforce = Workforce::findOrFail($request->workforce_id);
        $workforce->supplyCentres()->detach($request->supply_centre_id);
        return redirect()->route('workforce.dashboard')->with('success', 'Workforce unassigned successfully.');
    }

    public function storeWorkforce(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'nullable',
            'status' => 'required',
            'contact' => 'nullable',
        ]);
        Workforce::create($request->only('name', 'role', 'status', 'contact'));
        return redirect()->route('workforce.dashboard')->with('success', 'Workforce added successfully.');
    }

    public function deleteWorkforce($id)
    {
        Workforce::findOrFail($id)->delete();
        return redirect()->route('workforce.dashboard')->with('success', 'Workforce deleted successfully.');
    }

    public function storeSupplyCentre(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'nullable',
        ]);
        SupplyCentre::create($request->only('name', 'location'));
        return redirect()->route('workforce.dashboard')->with('success', 'Supply Centre added successfully.');
    }

    public function deleteSupplyCentre($id)
    {
        SupplyCentre::findOrFail($id)->delete();
        return redirect()->route('workforce.dashboard')->with('success', 'Supply Centre deleted successfully.');
    }
}
