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
        Schema::table('inventories', function (Blueprint $table) {
            // Drop 'name' column if it exists to avoid duplicate error
            if (Schema::hasColumn('inventories', 'name')) {
                $table->dropColumn('name');
            }
            // Rename 'item_name' to 'name' if it exists
            if (Schema::hasColumn('inventories', 'item_name')) {
                $table->renameColumn('item_name', 'name');
            }
            if (Schema::hasColumn('inventories', 'price')) {
                $table->renameColumn('price', 'unit_price');
            }
            // Add new columns if they don't exist
            if (!Schema::hasColumn('inventories', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('inventories', 'sku')) {
                $table->string('sku')->unique()->after('description');
            }
            if (!Schema::hasColumn('inventories', 'min_quantity')) {
                $table->integer('min_quantity')->default(10)->after('quantity');
            }
            if (!Schema::hasColumn('inventories', 'category')) {
                $table->string('category')->nullable()->after('unit_price');
            }
            if (!Schema::hasColumn('inventories', 'location')) {
                $table->string('location')->nullable()->after('category');
            }
            if (!Schema::hasColumn('inventories', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Reverse the changes
            if (Schema::hasColumn('inventories', 'name')) {
                $table->renameColumn('name', 'item_name');
            }
            if (Schema::hasColumn('inventories', 'unit_price')) {
                $table->renameColumn('unit_price', 'price');
            }
            if (Schema::hasColumn('inventories', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('inventories', 'sku')) {
                $table->dropUnique(['sku']);
                $table->dropColumn('sku');
            }
            if (Schema::hasColumn('inventories', 'min_quantity')) {
                $table->dropColumn('min_quantity');
            }
            if (Schema::hasColumn('inventories', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('inventories', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('inventories', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
