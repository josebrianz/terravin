<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('orders', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            // Optionally, add a foreign key:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    public function down() {
        Schema::table('orders', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}; 