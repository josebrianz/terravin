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
        Schema::table('messages', function (Blueprint $table) {
            $table->string('group')->nullable()->after('receiver_id');
            $table->unsignedBigInteger('reply_to')->nullable()->after('group');
            $table->foreign('reply_to')->references('id')->on('messages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('group');
            $table->dropForeign(['reply_to']);
            $table->dropColumn('reply_to');
        });
    }
};
