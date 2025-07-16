<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role model for this user
     */
    public function roleModel()
    {
        return Role::where('name', $this->role)->first();
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        $roleModel = $this->roleModel();
        return $roleModel ? $roleModel->hasPermission($permission) : false;
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has all of the given permissions
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if user can perform action on resource
     */
    public function canPerform(string $action, string $resource): bool
    {
        $permission = "{$action}_{$resource}";
        return $this->hasPermission($permission);
    }

    /**
     * Check if user can view their own data only
     */
    public function canViewOwn(string $resource): bool
    {
        return $this->hasPermission("view_own_{$resource}");
    }

    /**
     * Check if user can view all data
     */
    public function canViewAll(string $resource): bool
    {
        return $this->hasPermission("view_all_{$resource}") || $this->hasPermission("view_{$resource}");
    }

    /**
     * Get user's permissions as array
     */
    public function getPermissions(): array
    {
        $roleModel = $this->roleModel();
        return $roleModel ? $roleModel->permissions : [];
    }

    /**
     * Check if user has any admin permissions
     */
    public function hasAdminPermissions(): bool
    {
        return $this->hasAnyPermission([
            'manage_roles',
            'system_settings',
            'view_audit_logs'
        ]);
    }

    // Role helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isVendor(): bool
    {
        return $this->role === 'Vendor';
    }

    public function isRetailer(): bool
    {
        return $this->role === 'Retailer';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'Customer';
    }

    /**
     * Get all available roles
     */
    public static function getAvailableRoles(): array
    {
        return Role::getAvailableRoles();
    }

    /**
     * Get users by role
     */
    public static function getUsersByRole(string $role)
    {
        return self::where('role', $role)->get();
    }

    /**
     * Get role approval requests for this user
     */
    public function roleApprovalRequests()
    {
        return $this->hasMany(RoleApprovalRequest::class);
    }

    /**
     * Get pending role approval request for this user
     */
    public function getPendingRoleRequest()
    {
        return $this->roleApprovalRequests()->pending()->latest()->first();
    }

    /**
     * Check if user has a pending role approval request
     */
    public function hasPendingRoleRequest(): bool
    {
        return $this->roleApprovalRequests()->pending()->exists();
    }
}
