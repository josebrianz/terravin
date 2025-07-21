<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        {
            Schema::table('favorites', function (Blueprint $table) {
                $table->unsignedBigInteger('customer_id')->after('id');
            });
        }  
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