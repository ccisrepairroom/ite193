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
        Schema::create('reorder_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity')->index('reorder_request_quantity')->nullable()->onDelete('cascade');
            $table->dateTime('request_date')->index('reorder_request_request_date')->nullable()->onDelete('cascade');
            $table->string('status')->index('reorder_request_status')->nullable()->onDelete('cascade');
            $table->string('shipment_location')->index('reorder_request_shipment_location')->nullable()->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable()->index('reorder_request_product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('store_id')->nullable()->index('reorder_request_store_id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id')->nullable()->index('reorder_request_vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reorder_requests');
    }
};