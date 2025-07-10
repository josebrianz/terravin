<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update roles table - change role name from 'Supplier' to 'Wholesaler'
        DB::table('roles')
            ->where('name', 'Supplier')
            ->update([
                'name' => 'Wholesaler',
                'description' => 'Wholesaler access for order fulfillment and shipment management'
            ]);

        // Update role approval requests table
        DB::table('role_approval_requests')
            ->where('requested_role', 'Supplier')
            ->update(['requested_role' => 'Wholesaler']);

        // Update stakeholders table - change role from 'supplier' to 'wholesaler'
        DB::table('stakeholders')
            ->where('role', 'supplier')
            ->update(['role' => 'wholesaler']);

        // Rename procurement table columns from supplier_* to wholesaler_*
        Schema::table('procurements', function (Blueprint $table) {
            $table->renameColumn('supplier_name', 'wholesaler_name');
            $table->renameColumn('supplier_email', 'wholesaler_email');
            $table->renameColumn('supplier_phone', 'wholesaler_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert roles table
        DB::table('roles')
            ->where('name', 'Wholesaler')
            ->update([
                'name' => 'Supplier',
                'description' => 'Supplier access for order fulfillment and shipment management'
            ]);

        // Revert role approval requests table
        DB::table('role_approval_requests')
            ->where('requested_role', 'Wholesaler')
            ->update(['requested_role' => 'Supplier']);

        // Revert stakeholders table
        DB::table('stakeholders')
            ->where('role', 'wholesaler')
            ->update(['role' => 'supplier']);

        // Revert procurement table column names
        Schema::table('procurements', function (Blueprint $table) {
            $table->renameColumn('wholesaler_name', 'supplier_name');
            $table->renameColumn('wholesaler_email', 'supplier_email');
            $table->renameColumn('wholesaler_phone', 'supplier_phone');
        });
    }
};
