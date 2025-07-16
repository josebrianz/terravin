<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_amount', 12, 2)->nullable()->change();
        });
    }
    public function down() {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_amount', 12, 2)->nullable(false)->change();
        });
    }
}; 