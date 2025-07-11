<?php

use App\Models\User;
use App\Models\RoleApprovalRequest;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed the roles before each test
    $roles = Role::getAvailableRoles();
    foreach ($roles as $roleName => $roleData) {
        Role::create([
            'name' => $roleName,
            'description' => $roleData['description'],
            'permissions' => $roleData['permissions']
        ]);
    }
});

test('user registration creates role approval request', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'Vendor',
    ]);

    $this->assertAuthenticated();
    
    $user = User::where('email', 'test@example.com')->first();
    $this->assertEquals('Customer', $user->role);
    
    $roleRequest = RoleApprovalRequest::where('user_id', $user->id)->first();
    $this->assertNotNull($roleRequest);
    $this->assertEquals('Vendor', $roleRequest->requested_role);
    $this->assertEquals('pending', $roleRequest->status);
});

test('admin can view role approval requests', function () {
    $admin = User::factory()->create(['role' => 'Admin']);
    $user = User::factory()->create(['role' => 'Customer']);
    
    RoleApprovalRequest::create([
        'user_id' => $user->id,
        'requested_role' => 'Vendor',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->get('/admin/role-approvals');

    $response->assertStatus(200);
    $response->assertSee('Role Approval Requests');
    $response->assertSee($user->name);
    $response->assertSee('Vendor');
});

test('admin can approve role request', function () {
    $admin = User::factory()->create(['role' => 'Admin']);
    $user = User::factory()->create(['role' => 'Customer']);
    
    $roleRequest = RoleApprovalRequest::create([
        'user_id' => $user->id,
        'requested_role' => 'Vendor',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post("/admin/role-approvals/{$roleRequest->id}/approve", [
        'admin_notes' => 'Approved for vendor role',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);
    
    $user->refresh();
    $roleRequest->refresh();
    
    $this->assertEquals('Vendor', $user->role);
    $this->assertEquals('approved', $roleRequest->status);
    $this->assertEquals($admin->id, $roleRequest->approved_by);
});

test('admin can reject role request', function () {
    $admin = User::factory()->create(['role' => 'Admin']);
    $user = User::factory()->create(['role' => 'Customer']);
    
    $roleRequest = RoleApprovalRequest::create([
        'user_id' => $user->id,
        'requested_role' => 'Vendor',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post("/admin/role-approvals/{$roleRequest->id}/reject", [
        'admin_notes' => 'Insufficient experience',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['success' => true]);
    
    $user->refresh();
    $roleRequest->refresh();
    
    $this->assertEquals('Customer', $user->role); // Role should remain unchanged
    $this->assertEquals('rejected', $roleRequest->status);
    $this->assertEquals($admin->id, $roleRequest->approved_by);
});

test('user can see pending role request notification', function () {
    $user = User::factory()->create(['role' => 'Customer']);
    
    RoleApprovalRequest::create([
        'user_id' => $user->id,
        'requested_role' => 'Vendor',
        'status' => 'pending',
    ]);

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Role Upgrade Request Pending');
    $response->assertSee('Vendor');
}); 