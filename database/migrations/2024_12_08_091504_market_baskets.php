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
        Schema::create('market_baskets', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_amount',8,2)->index('market_basket_total_amount')->nullable()->onDelete('cascade');
            $table->dateTime('purchase_date')->index('market_basket_purchase_date')->nullable()->onDelete('cascade');
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->nullable()->index('market_basket_user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('store_id')->nullable()->index('market_basket_store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('market_baskets');
    }
};