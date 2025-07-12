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
        // Step 1: First, modify the enum to include both 'Supplier' and 'Wholesaler'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Vendor', 'Supplier', 'Wholesaler', 'Customer') DEFAULT 'Customer'");

        // Step 2: Update any existing 'Supplier' values to 'Wholesaler'
        DB::table('users')
            ->where('role', 'Supplier')
            ->update(['role' => 'Wholesaler']);

        // Step 3: Now remove 'Supplier' from the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Vendor', 'Wholesaler', 'Customer') DEFAULT 'Customer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: First, modify the enum to include both 'Supplier' and 'Wholesaler'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Vendor', 'Supplier', 'Wholesaler', 'Customer') DEFAULT 'Customer'");

        // Step 2: Update any existing 'Wholesaler' values to 'Supplier'
        DB::table('users')
            ->where('role', 'Wholesaler')
            ->update(['role' => 'Supplier']);

        // Step 3: Now remove 'Wholesaler' from the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Vendor', 'Supplier', 'Customer') DEFAULT 'Customer'");
    }
};
