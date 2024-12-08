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
            $table->string('name')->index('product_name')->nullable()->onDelete('cascade');
            $table->string('product_image')->index('product_product_image')->nullable()->onDelete('cascade');
            $table->string('size')->index('product_size')->nullable()->onDelete('cascade');
            $table->string('upc_code')->unique()->index('product_upc_code')->nullable()->onDelete('cascade');
            $table->decimal('price',8,2)->index('product_price')->nullable()->onDelete('cascade');

            $table->unsignedBigInteger('brand_id')->nullable()->index('product_brand_id');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};