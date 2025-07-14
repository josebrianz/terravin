<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    public function up()
    {
     Schema::create('vendors', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('company_name');
        $table->string('contact_person');
        $table->string('phone');
        $table->integer('years_in_operation');
        $table->integer('employees');
        $table->decimal('turnover', 15, 2);
        $table->string('material');
        $table->string('clients')->nullable();
        $table->boolean('certification_organic')->default(false);
        $table->boolean('certification_iso')->default(false);
        $table->boolean('regulatory_compliance')->default(false);
        $table->string('validation_status')->default('pending');
        $table->string('application_pdf');
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
