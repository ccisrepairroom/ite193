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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity')->index('inventory_quantity')->nullable()->onDelete('cascade');
            $table->unsignedInteger('reorderPoint')->index('inventory_reorder_point')->nullable()->onDelete('cascade');
            $table->unsignedInteger('updated_quantity')->index('inventory_updated_quantity')->nullable()->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable()->index('inventory_product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('store_id')->nullable()->index('inventory_store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};