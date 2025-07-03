<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workforces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('status')->default('available');
            $table->string('contact')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workforces');
    }
}; 