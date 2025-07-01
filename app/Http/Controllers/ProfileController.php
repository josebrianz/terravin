<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show all users for role management (admin only).
     */
    public function manageRoles(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            abort(403);
        }
        $users = \App\Models\User::all();
        return view('admin.manage-roles', compact('users'));
    }

    /**
     * Update a user's role (admin only).
     */
    public function updateRole(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            abort(403);
        }
        $request->validate([
            'role' => 'required|in:Admin,Vendor,Supplier,Customer',
        ]);
        $user = \App\Models\User::findOrFail($id);
        $user->role = $request->role;
        $user->save();
        return redirect()->back()->with('status', 'Role updated successfully.');
    }

    /**
     * Add a new user (admin only).
     */
    public function addUser(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            abort(403);
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:Admin,Vendor,Supplier,Customer',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = new \App\Models\User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->password = \Hash::make($validated['password']);
        $user->save();
        return redirect()->route('admin.manage-roles')->with('status', 'User added successfully.');
    }

    /**
     * Show edit form for a user (admin only).
     */
    public function editUser(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            abort(403);
        }
        $user = \App\Models\User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update a user (admin only).
     */
    public function updateUser(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            abort(403);
        }
        $user = \App\Models\User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:Admin,Vendor,Supplier,Customer',
            'password' => 'nullable|confirmed|min:6',
        ]);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        if (!empty($validated['password'])) {
            $user->password = \Hash::make($validated['password']);
        }
        $user->save();
        return redirect()->route('admin.manage-roles')->with('status', 'User updated successfully.');
    }

    /**
     * Delete a user (admin only).
     */
    public function deleteUser(Request $request, $id)
    {
        if (!$request->user()->isAdmin()) {
            abort(403);
        }
        $user = \App\Models\User::findOrFail($id);
        if ($user->id == $request->user()->id) {
            return redirect()->back()->with('status', 'You cannot delete your own account.');
        }
        $user->delete();
        return redirect()->route('admin.manage-roles')->with('status', 'User deleted successfully.');
    }
}
