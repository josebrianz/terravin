<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->text('notes')->nullable();
            $table->text('items')->nullable();
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->timestamps();
            // Add indexes and foreign keys as needed
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('vendor_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    public function down() {
        Schema::dropIfExists('orders');
    }
}; 