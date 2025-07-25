<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('Admin','Vendor','Supplier','Retailer','Customer') NOT NULL DEFAULT 'Customer'");
    }
    public function down(): void
    {
        // Optionally revert to previous ENUM values if needed
        DB::statement("ALTER TABLE users MODIFY role ENUM('Admin','Vendor','Wholesaler','Retailer','Customer') NOT NULL DEFAULT 'Customer'");
    }
}; 