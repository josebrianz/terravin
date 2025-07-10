<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (!Schema::hasColumn('inventories', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('inventories', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (!Schema::hasColumn('inventories', 'sku')) {
                $table->string('sku')->unique()->after('description');
            }
            if (!Schema::hasColumn('inventories', 'quantity')) {
                $table->integer('quantity')->default(0)->after('sku');
            }
            if (!Schema::hasColumn('inventories', 'min_quantity')) {
                $table->integer('min_quantity')->default(10)->after('quantity');
            }
            if (!Schema::hasColumn('inventories', 'unit_price')) {
                $table->decimal('unit_price', 10, 2)->default(0)->after('min_quantity');
            }
            if (!Schema::hasColumn('inventories', 'category')) {
                $table->string('category')->nullable()->after('unit_price');
            }
            if (!Schema::hasColumn('inventories', 'location')) {
                $table->string('location')->nullable()->after('category');
            }
            if (!Schema::hasColumn('inventories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('location');
            }
        });
    }

    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (Schema::hasColumn('inventories', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('inventories', 'location')) {
                $table->dropColumn('location');
            }
            if (Schema::hasColumn('inventories', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('inventories', 'unit_price')) {
                $table->dropColumn('unit_price');
            }
            if (Schema::hasColumn('inventories', 'min_quantity')) {
                $table->dropColumn('min_quantity');
            }
            if (Schema::hasColumn('inventories', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('inventories', 'sku')) {
                $table->dropUnique(['sku']);
                $table->dropColumn('sku');
            }
            if (Schema::hasColumn('inventories', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('inventories', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
}; 