<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (Schema::hasColumn('inventories', 'item_code')) {
                $table->dropColumn('item_code');
            }
        });
    }

    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (!Schema::hasColumn('inventories', 'item_code')) {
                $table->string('item_code')->nullable();
            }
        });
    }
}; 