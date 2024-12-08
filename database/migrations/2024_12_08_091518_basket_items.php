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
        Schema::create('basket_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity')->index('basket_item_quantity')->nullable()->onDelete('cascade');

            $table->unsignedBigInteger('market_basket_id')->nullable()->index('basket_item_market_basket_id');
            $table->foreign('market_basket_id')->references('id')->on('market_baskets')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable()->index('basket_item_product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_items');
    }
};