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
        // Add Supplier role to roles table if it doesn't exist
        if (!Role::where('name', 'Supplier')->exists()) {
            Role::create([
                'name' => 'Supplier',
                'description' => 'Supplier access for order fulfillment',
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
        Role::where('name', 'Supplier')->delete();
    }
};
