<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('report_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stakeholder_id')->constrained('stakeholders')->onDelete('cascade');
            $table->enum('frequency', ['daily', 'weekly', 'monthly']);
            $table->json('report_types'); // e.g. ["inventory", "orders"]
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_preferences');
    }
}; 