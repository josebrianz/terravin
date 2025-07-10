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
        Schema::table('notifications', function (Blueprint $table) {
            if (!Schema::hasColumn('notifications', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('notifications', 'type')) {
                $table->string('type')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('notifications', 'title')) {
                $table->string('title')->after('type');
            }
            if (!Schema::hasColumn('notifications', 'message')) {
                $table->text('message')->after('title');
            }
            if (!Schema::hasColumn('notifications', 'icon')) {
                $table->string('icon')->nullable()->after('message');
            }
            if (!Schema::hasColumn('notifications', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('icon');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'read_at')) {
                $table->dropColumn('read_at');
            }
            if (Schema::hasColumn('notifications', 'icon')) {
                $table->dropColumn('icon');
            }
            if (Schema::hasColumn('notifications', 'message')) {
                $table->dropColumn('message');
            }
            if (Schema::hasColumn('notifications', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('notifications', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('notifications', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};
