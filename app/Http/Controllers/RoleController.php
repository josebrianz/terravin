<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    /**
     * Display the role management page
     */
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $availableRoles = Role::getAvailableRoles();

        return view('admin.manage-roles', compact('users', 'roles', 'availableRoles'));
    }

    /**
     * Update a user's role
     */
    public function updateUserRole(Request $request, $userId)
    {
        // Check if user has permission to manage roles
        if (!auth()->user()->hasPermission('manage_roles')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to manage roles.'
            ], 403);
        }

        $request->validate([
            'role' => 'required|string|in:Admin,Vendor,Retailer,Wholesaler,Customer'
        ]);

        $user = User::findOrFail($userId);
        $oldRole = $user->role;
        $newRole = $request->role;
        
        // Prevent users from changing their own role
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot change your own role.'
            ], 403);
        }
        
        // Prevent changing the last admin's role
        if ($oldRole === 'Admin' && $newRole !== 'Admin') {
            $adminCount = User::where('role', 'Admin')->count();
            if ($adminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot change the last administrator\'s role. At least one admin must remain in the system.'
                ], 403);
            }
        }
        
        $user->update(['role' => $newRole]);
        
        // Log the role change using the new audit system
        \App\Models\AuditLog::logRoleChange($user, $oldRole, $newRole, auth()->user());

        return response()->json([
            'success' => true,
            'message' => "User role updated successfully from {$oldRole} to {$newRole}."
        ]);
    }

    /**
     * Create a new user
     */
    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:Admin,Vendor,Retailer,Wholesaler,Customer'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    /**
     * Edit user form
     */
    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        $availableRoles = Role::getAvailableRoles();

        return view('admin.edit-user', compact('user', 'availableRoles'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'role' => 'required|string|in:Admin,Vendor,Retailer,Wholesaler,Customer'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.manage-roles')->with('success', 'User updated successfully.');
    }

    /**
     * Delete user
     */
    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    /**
     * Get users by role
     */
    public function getUsersByRole($role)
    {
        $users = User::where('role', $role)->get();
        return response()->json($users);
    }

    /**
     * Get role statistics
     */
    public function getRoleStats()
    {
        $stats = [];
        $roles = Role::getAvailableRoles();

        foreach (array_keys($roles) as $role) {
            $stats[$role] = User::where('role', $role)->count();
        }

        return response()->json($stats);
    }
} 