<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supply_centre_workforce', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workforce_id')->constrained()->onDelete('cascade');
            $table->foreignId('supply_centre_id')->constrained()->onDelete('cascade');
            $table->date('assigned_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supply_centre_workforce');
    }
}; 