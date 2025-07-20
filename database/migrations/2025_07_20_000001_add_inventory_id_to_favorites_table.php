<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('favorites', function (Blueprint $table) {
            if (!Schema::hasColumn('favorites', 'inventory_id')) {
                $table->foreignId('inventory_id')->after('customer_id')->constrained('inventories')->onDelete('cascade');
            }
        });
    }
    public function down() {
        Schema::table('favorites', function (Blueprint $table) {
            if (Schema::hasColumn('favorites', 'inventory_id')) {
                $table->dropForeign(['inventory_id']);
                $table->dropColumn('inventory_id');
            }
        });
    }
}; 