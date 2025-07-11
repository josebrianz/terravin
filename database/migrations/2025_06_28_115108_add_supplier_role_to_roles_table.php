<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add Wholesaler role to roles table if it doesn't exist
        if (!Role::where('name', 'Wholesaler')->exists()) {
            Role::create([
                'name' => 'Wholesaler',
                'description' => 'Wholesaler access for order fulfillment',
                'permissions' => [
                    'view_orders',
                    'update_order_status',
                    'view_inventory',
                    'manage_shipments'
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove Supplier role
        Role::where('name', 'Wholesaler')->delete();
    }
};
