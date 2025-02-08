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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->enum('type',['attribute','simple'])->default('simple');
            $table->string('name');
            $table->integer('price');
            $table->integer('weight');
            $table->longText('desc');
            $table->integer('point');
            $table->enum('status',['active','nonactive','deleted']);
            $table->string('img_thumbnail');
            $table->enum('is_popular',['popular','notpopular']);
            $table->integer('discount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
