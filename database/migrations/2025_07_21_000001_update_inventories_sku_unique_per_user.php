<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->unique(['user_id', 'sku']);
        });
    }

    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'sku']);
            $table->unique('sku');
        });
    }
}; 