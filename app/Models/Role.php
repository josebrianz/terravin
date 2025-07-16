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
                'description' => 'Full system access with complete administrative privileges',
                'permissions' => [
                    // User Management
                    'view_users',
                    'create_users',
                    'edit_users',
                    'delete_users',
                    'manage_roles',
                    
                    // Inventory Management
                    'view_inventory',
                    'create_inventory',
                    'edit_inventory',
                    'delete_inventory',
                    'manage_inventory_categories',
                    
                    // Order Management
                    'view_orders',
                    'create_orders',
                    'edit_orders',
                    'delete_orders',
                    'update_order_status',
                    'view_all_orders',
                    
                    // Procurement Management
                    'view_procurement',
                    'create_procurement',
                    'edit_procurement',
                    'delete_procurement',
                    'approve_procurement',
                    'update_procurement_status',
                    
                    // Logistics Management
                    'view_logistics',
                    'manage_shipments',
                    'track_shipments',
                    'update_shipment_status',
                    
                    // Reports & Analytics
                    'view_reports',
                    'export_reports',
                    'view_analytics',
                    
                    // System Settings
                    'system_settings',
                    'view_audit_logs',
                    'manage_notifications'
                ]
            ],
            'Vendor' => [
                'description' => 'Vendor access for order management and inventory viewing',
                'permissions' => [
                    'view_inventory',
                    'view_orders',
                    'update_order_status',
                    'view_order_details',
                    'create_order_reports',
                    'view_customer_info'
                ]
            ],
            'Retailer' => [
                'description' => 'Retailer access for procurement and inventory management',
                'permissions' => [
                    'view_inventory',
                    'view_procurement',
                    'create_procurement',
                    'edit_procurement',
                    'update_procurement_status',
                    'view_supplier_info',
                    'create_procurement_reports',
                    'view_orders',
                    'view_order_details',
                    'create_orders',
                    'edit_orders',
                    'delete_orders',
                ]
            ],
            'Customer' => [
                'description' => 'Basic customer access for order management',
                'permissions' => [
                    'view_own_orders',
                    'create_orders',
                    'edit_own_orders',
                    'cancel_own_orders',
                    'view_available_inventory',
                    'view_order_history',
                    'track_own_shipments'
                ]
            ]
        ];
    }
}
