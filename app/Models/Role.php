<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    /**
     * Get users with this role
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }

    /**
     * Get all available roles
     */
    public static function getAvailableRoles(): array
    {
        return [
            'Admin' => [
                'description' => 'Full system access',
                'permissions' => [
                    'manage_users',
                    'manage_roles',
                    'manage_inventory',
                    'manage_orders',
                    'manage_procurement',
                    'manage_logistics',
                    'view_reports',
                    'system_settings'
                ]
            ],
            'Vendor' => [
                'description' => 'Vendor access for order management',
                'permissions' => [
                    'view_orders',
                    'update_order_status',
                    'view_inventory'
                ]
            ],
            'Retailer' => [
                'description' => 'Retailer access for procurement',
                'permissions' => [
                    'view_procurement',
                    'update_procurement_status',
                    'view_inventory'
                ]
            ],
            'Supplier' => [
                'description' => 'Supplier access for order fulfillment',
                'permissions' => [
                    'view_orders',
                    'update_order_status',
                    'view_inventory',
                    'manage_shipments'
                ]
            ],
            'Customer' => [
                'description' => 'Basic customer access',
                'permissions' => [
                    'view_orders',
                    'create_orders'
                ]
            ]
        ];
    }
}
