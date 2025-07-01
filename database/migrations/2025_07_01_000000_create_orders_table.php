<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('shipping_address');
            $table->text('notes')->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('orders');
    }
}; 