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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('customer_name');
            $table->string('address');
            $table->string('phone');
            $table->integer('total_price');
            $table->integer('tax_amount');
            $table->integer('tax');
            $table->integer('point_out')->default(0);
            $table->integer('final_price');
            $table->string('total_weight');
            $table->integer('shipping_cost')->default(0);
            $table->string('customer_city_id')->nullable();
            $table->string('customer_province_id')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_province')->nullable();
            $table->string('shipping_courier')->nullable();
            $table->string('shipping_service_name')->nullable();
            $table->string('track_number')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->enum('status',['unpaid','paid','shipping','finish'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
