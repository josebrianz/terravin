<?php

namespace App\Http\Controllers;

use App\Models\RoleApprovalRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleApprovalController extends Controller
{
    /**
     * Display the role approval requests page
     */
    public function index()
    {
        // Check if user has permission to manage roles
        if (!auth()->user()->hasPermission('manage_roles')) {
            abort(403, 'Access denied. Insufficient permissions.');
        }

        $pendingRequests = RoleApprovalRequest::with(['user', 'approver'])
            ->pending()
            ->latest()
            ->get();

        $approvedRequests = RoleApprovalRequest::with(['user', 'approver'])
            ->approved()
            ->latest()
            ->limit(10)
            ->get();

        $rejectedRequests = RoleApprovalRequest::with(['user', 'approver'])
            ->rejected()
            ->latest()
            ->limit(10)
            ->get();

        $stats = [
            'pending' => RoleApprovalRequest::pending()->count(),
            'approved' => RoleApprovalRequest::approved()->count(),
            'rejected' => RoleApprovalRequest::rejected()->count(),
            'total' => RoleApprovalRequest::count(),
        ];

        return view('admin.role-approvals', compact(
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'stats'
        ));
    }

    /**
     * Show a specific role approval request
     */
    public function show(RoleApprovalRequest $roleApprovalRequest)
    {
        // Check if user has permission to manage roles
        if (!auth()->user()->hasPermission('manage_roles')) {
            abort(403, 'Access denied. Insufficient permissions.');
        }

        $roleApprovalRequest->load(['user', 'approver']);
        
        return view('admin.role-approval-show', compact('roleApprovalRequest'));
    }

    /**
     * Approve a role approval request
     */
    public function approve(Request $request, RoleApprovalRequest $roleApprovalRequest)
    {
        // Check if user has permission to manage roles
        if (!auth()->user()->hasPermission('manage_roles')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to manage roles.'
            ], 403);
        }

        // Check if request is already processed
        if (!$roleApprovalRequest->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been processed.'
            ], 400);
        }

        DB::transaction(function () use ($roleApprovalRequest, $request) {
            // Update the user's role
            $user = $roleApprovalRequest->user;
            $user->update(['role' => $roleApprovalRequest->requested_role]);

            // Update the approval request
            $roleApprovalRequest->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'admin_notes' => $request->input('admin_notes'),
                'approved_at' => now(),
            ]);

            // Log the role change
            \App\Models\AuditLog::logRoleChange(
                $user, 
                'Customer', 
                $roleApprovalRequest->requested_role, 
                auth()->user(),
                'Approved via role approval request'
            );

            // Notify the user
            $user->notify(new \App\Notifications\RoleApprovedNotification($roleApprovalRequest->requested_role));
        });

        return response()->json([
            'success' => true,
            'message' => 'Role approval request approved successfully.'
        ]);
    }

    /**
     * Reject a role approval request
     */
    public function reject(Request $request, RoleApprovalRequest $roleApprovalRequest)
    {
        // Check if user has permission to manage roles
        if (!auth()->user()->hasPermission('manage_roles')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to manage roles.'
            ], 403);
        }

        // Check if request is already processed
        if (!$roleApprovalRequest->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been processed.'
            ], 400);
        }

        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        // Update the approval request
        $roleApprovalRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'admin_notes' => $request->input('admin_notes'),
            'approved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role approval request rejected successfully.'
        ]);
    }

    /**
     * Get role approval statistics for dashboard
     */
    public function getStats()
    {
        if (!auth()->user()->hasPermission('manage_roles')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $stats = [
            'pending' => RoleApprovalRequest::pending()->count(),
            'approved' => RoleApprovalRequest::approved()->count(),
            'rejected' => RoleApprovalRequest::rejected()->count(),
            'total' => RoleApprovalRequest::count(),
        ];

        return response()->json($stats);
    }
}
