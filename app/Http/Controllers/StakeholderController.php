<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use App\Models\ReportPreference;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'role' => 'required|in:company manager,sales manager',
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
            'role' => 'required|in:company manager,sales manager',
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
            'report_types' => 'required|array',
        ]);
        $data = $request->only('frequency', 'report_types');
        $data['report_types'] = array_values($data['report_types']); // ensure array
        $stakeholder->reportPreference()->updateOrCreate(
            [],
            [
                'frequency' => $data['frequency'],
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

    public function showReports()
    {
        $user = auth()->user();
        $stakeholder = \App\Models\Stakeholder::where('role', $user->role)->first();
        if ($stakeholder && $stakeholder->reportPreference) {
            $reportData = \App\Services\ReportService::generateForStakeholder($stakeholder);
        } else {
            // Fallback to default preferences if no stakeholder or preferences
            $preferences = [
                'frequency' => 'weekly',
                'report_types' => ['inventory', 'orders', 'procurement']
            ];
            $reportData = \App\Services\ReportService::generateForUser($user, $preferences);
        }
        $pdf = \PDF::loadView('stakeholders.reports_pdf', [
            'user' => $user,
            'reportData' => $reportData
        ]);
        $filename = 'report_' . $user->id . '.pdf';
        if (request()->query('download')) {
            return $pdf->download($filename);
        }
        return $pdf->stream($filename);
    }

    public function showReportsForStakeholder($id)
    {
        $stakeholder = \App\Models\Stakeholder::findOrFail($id);
        $preferences = $stakeholder->reportPreference;
        if (!$preferences) {
            // Fallback to default if no preferences set
            $preferences = [
                'frequency' => 'weekly',
                'report_types' => ['inventory', 'orders', 'procurement']
            ];
        }
        $reportData = \App\Services\ReportService::generateForStakeholder($stakeholder);
        $pdf = \PDF::loadView('stakeholders.reports_pdf', [
            'stakeholder' => $stakeholder,
            'reportData' => $reportData
        ]);
        $filename = 'report_' . $stakeholder->id . '.pdf';
        if (request()->query('download')) {
            return $pdf->download($filename);
        }
        return $pdf->stream($filename);
    }
}
