<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecurityController extends Controller
{
    /**
     * Display the security dashboard
     */
    public function index()
    {
        // Check if user has permission to view audit logs
        if (!auth()->user()->hasPermission('view_audit_logs')) {
            abort(403, 'Access denied. Insufficient permissions.');
        }

        // Get recent security events
        $recentEvents = AuditLog::getSecurityEvents(20);
        
        // Get role statistics
        $roleStats = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();

        // Get permission denied events in last 24 hours
        $permissionDenials = AuditLog::where('action', 'permission_denied')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        // Get role changes in last 7 days
        $roleChanges = AuditLog::where('action', 'role_changed')
            ->where('created_at', '>=', now()->subWeek())
            ->count();

        // Get user activity summary
        $userActivity = AuditLog::select('user_id', DB::raw('count(*) as activity_count'))
            ->where('created_at', '>=', now()->subWeek())
            ->groupBy('user_id')
            ->orderBy('activity_count', 'desc')
            ->limit(10)
            ->with('user')
            ->get();

        return view('admin.security-dashboard', compact(
            'recentEvents',
            'roleStats',
            'permissionDenials',
            'roleChanges',
            'userActivity'
        ));
    }

    /**
     * Display audit logs for a specific user
     */
    public function userAuditLogs($userId)
    {
        if (!auth()->user()->hasPermission('view_audit_logs')) {
            abort(403, 'Access denied. Insufficient permissions.');
        }

        $user = User::findOrFail($userId);
        $auditLogs = AuditLog::getUserAuditLogs($userId, 100);

        return view('admin.user-audit-logs', compact('user', 'auditLogs'));
    }

    /**
     * Display all audit logs with filtering
     */
    public function auditLogs(Request $request)
    {
        if (!auth()->user()->hasPermission('view_audit_logs')) {
            abort(403, 'Access denied. Insufficient permissions.');
        }

        $query = AuditLog::with('user');

        // Apply filters
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('resource_type')) {
            $query->where('resource_type', $request->resource_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->paginate(50);

        // Get available filter options
        $actions = AuditLog::distinct()->pluck('action')->toArray();
        $resourceTypes = AuditLog::distinct()->pluck('resource_type')->toArray();
        $users = User::all(['id', 'name', 'email']);

        return view('admin.audit-logs', compact('auditLogs', 'actions', 'resourceTypes', 'users'));
    }

    /**
     * Export audit logs
     */
    public function exportAuditLogs(Request $request)
    {
        if (!auth()->user()->hasPermission('export_reports')) {
            abort(403, 'Access denied. Insufficient permissions.');
        }

        $query = AuditLog::with('user');

        // Apply same filters as audit logs view
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('resource_type')) {
            $query->where('resource_type', $request->resource_type);
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to);
        }

        $auditLogs = $query->orderBy('created_at', 'desc')->get();

        // Generate CSV
        $filename = 'audit_logs_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($auditLogs) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'User', 'Action', 'Resource Type', 'Resource ID', 
                'Old Values', 'New Values', 'IP Address', 'User Agent', 
                'Details', 'Created At'
            ]);

            // CSV data
            foreach ($auditLogs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user->email ?? 'N/A',
                    $log->action,
                    $log->resource_type,
                    $log->resource_id,
                    json_encode($log->old_values),
                    json_encode($log->new_values),
                    $log->ip_address,
                    $log->user_agent,
                    json_encode($log->details),
                    $log->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
} 