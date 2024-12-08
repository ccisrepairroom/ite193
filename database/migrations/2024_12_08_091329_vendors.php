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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index('vendor_name')->nullable()->onDelete('cascade');
            $table->string('vendor_image')->index('vendor_vendor_image')->nullable()->onDelete('cascade');
            $table->string('location')->index('vendor_location')->nullable()->onDelete('cascade');
            $table->string('contact_number')->index('vendor_contact_number')->nullable()->onDelete('cascade');
            $table->timestamps();



         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};