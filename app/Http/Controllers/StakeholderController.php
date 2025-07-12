<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use App\Models\ReportPreference;
use Illuminate\Http\Request;

class StakeholderController extends Controller
{
    public function index()
    {
        $stakeholders = Stakeholder::all();
        return view('stakeholders.index', compact('stakeholders'));
    }

    public function create()
    {
        return view('stakeholders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:stakeholders,email',
            'role' => 'required|in:wholesaler,company manager,wholesaler,sales manager',
        ]);
        $stakeholder = Stakeholder::create($request->only('name', 'email', 'role'));
        return redirect()->route('stakeholders.index')->with('success', 'Stakeholder created!');
    }

    public function edit($id)
    {
        $stakeholder = Stakeholder::findOrFail($id);
        return view('stakeholders.edit', compact('stakeholder'));
    }

    public function update(Request $request, $id)
    {
        $stakeholder = Stakeholder::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:stakeholders,email,' . $stakeholder->id,
            'role' => 'required|in:wholesaler,company manager,wholesaler,sales manager',
        ]);
        $stakeholder->update($request->only('name', 'email', 'role'));
        return redirect()->route('stakeholders.index')->with('success', 'Stakeholder updated!');
    }

    public function destroy($id)
    {
        $stakeholder = Stakeholder::findOrFail($id);
        $stakeholder->delete();
        return redirect()->route('stakeholders.index')->with('success', 'Stakeholder deleted!');
    }

    // Preferences
    public function preferences($id)
    {
        $stakeholder = Stakeholder::findOrFail($id);
        $preference = $stakeholder->reportPreference;
        return view('stakeholders.preferences', compact('stakeholder', 'preference'));
    }

    public function updatePreferences(Request $request, $id)
    {
        $stakeholder = Stakeholder::findOrFail($id);
        $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly',
            'format' => 'required|in:email,pdf,excel',
            'report_types' => 'required|array',
        ]);
        $data = $request->only('frequency', 'format', 'report_types');
        $data['report_types'] = array_values($data['report_types']); // ensure array
        $stakeholder->reportPreference()->updateOrCreate(
            [],
            [
                'frequency' => $data['frequency'],
                'format' => $data['format'],
                'report_types' => $data['report_types'],
            ]
        );
        return redirect()->route('stakeholders.dashboard')->with('success', 'Preferences updated!');
    }

    public function dashboard()
    {
        $stakeholders = Stakeholder::with('reportPreference')->get();
        return view('stakeholders.dashboard', compact('stakeholders'));
    }
}
