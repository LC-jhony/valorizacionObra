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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->decimal('code', 10, 2);
            $table->string('name');
            $table->decimal('pu', 10, 2);
            $table->string('um');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->decimal('quantity', 10, 2);
            $table->unsignedBigInteger('category_id');
            $table->foreign('order_id')->references('id')->on('order_parchuses')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
