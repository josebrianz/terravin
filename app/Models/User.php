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

    public function isSupplier(): bool
    {
        return $this->role === 'Supplier';
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
}
