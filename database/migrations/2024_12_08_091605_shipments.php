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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('shipment_date')->index('shipment_shipment_date')->nullable()->onDelete('cascade');
            $table->dateTime('delivery_date')->index('shipment_delivery_date')->nullable()->onDelete('cascade');

            $table->unsignedBigInteger('vendor_id')->nullable()->index('shipment_vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->unsignedBigInteger('reorder_request_id')->nullable()->index('shipment_reorder_request_id');
            $table->foreign('reorder_request_id')->references('id')->on('reorder_requests')->onDelete('cascade');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};