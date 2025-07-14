<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleApprovalRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:Vendor,Wholesaler,Retailer'],
        ]);

        // Create user with Customer role initially
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Customer', // Default to Customer role
        ]);

        // Create role approval request
        RoleApprovalRequest::create([
            'user_id' => $user->id,
            'requested_role' => $request->role,
            'status' => 'pending',
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($request->role === 'Vendor') {
            return redirect()->route('vendor.apply');
}

        return redirect()->route('application.status')
            ->with('success', 'Account created successfully! Your role upgrade request has been submitted and is pending admin approval.');
    }

    /**
     * Display admin registration view (for creating users with specific roles)
     */
    public function createAdmin(): View
    {
        $availableRoles = Role::getAvailableRoles();
        return view('auth.register-admin', compact('availableRoles'));
    }

    /**
     * Handle admin user creation with role assignment
     */
    public function storeAdmin(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:Admin,Vendor,Retailer,Wholesaler,Customer'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        return redirect()->route('admin.manage-roles')->with('success', 'User created successfully with role: ' . $request->role);
    }
}
