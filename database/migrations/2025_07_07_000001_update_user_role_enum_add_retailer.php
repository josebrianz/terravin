<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('Wholesaler','Admin','Vendor','Retailer','Customer') NOT NULL DEFAULT 'Customer'");
    }
    public function down(): void
    {
        // Set all roles to 'Customer' before changing the ENUM to avoid truncation errors
        DB::statement("UPDATE users SET role = 'Customer' WHERE role NOT IN ('Admin','Vendor','Wholesaler','Customer')");
        DB::statement("ALTER TABLE users MODIFY role ENUM('Admin','Vendor','Wholesaler','Customer') NOT NULL DEFAULT 'Customer'");
    }
}; 