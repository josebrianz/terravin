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
        // Update any existing users with Manager role to Admin role
        DB::table('users')
            ->where('role', 'Manager')
            ->update(['role' => 'Admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert Admin users back to Manager (if needed)
        // Note: This is a destructive operation and should be used carefully
        // DB::table('users')
        //     ->where('role', 'Admin')
        //     ->update(['role' => 'Manager']);
    }
};
