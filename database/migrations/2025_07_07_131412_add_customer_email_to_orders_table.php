<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add customer_name
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->after('user_id'); // Add it after user_id for logical flow
            }

            // Add customer_email
            if (!Schema::hasColumn('orders', 'customer_email')) {
                $table->string('customer_email')->after('customer_name'); // Now customer_name exists
            }

            // Add customer_phone
            if (!Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone')->after('customer_email');
            }

            // Add shipping_address
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->string('shipping_address')->after('customer_phone');
            }

            // Add notes
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('shipping_address');
            }

            // If 'status' is missing from the table but exists in the original file:
            // Check if the current 'status' column exists and needs to be redefined or added.
            // Based on tbl.PNG, 'status' *does* exist, so no need to add it here.
            // Same for 'total_amount', 'created_at', 'updated_at'. They are already there.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('orders', 'shipping_address')) {
                $table->dropColumn('shipping_address');
            }
            if (Schema::hasColumn('orders', 'customer_phone')) {
                $table->dropColumn('customer_phone');
            }
            if (Schema::hasColumn('orders', 'customer_email')) {
                $table->dropColumn('customer_email');
            }
            if (Schema::hasColumn('orders', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
        });
    }
};