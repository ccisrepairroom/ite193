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
        Schema::create('sub_product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index('sub_product_type_name')->nullable()->onDelete('cascade');
            $table->unsignedBigInteger('product_type_id')->nullable()->index('sub_product_type_product_type_id');
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_product_types');
    }
};