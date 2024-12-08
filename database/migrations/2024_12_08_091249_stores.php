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
        Schema::create('stores', function (Blueprint $table) {
                $table->id();
                $table->string('name')->index('store_name')->nullable()->onDelete('cascade');
                $table->string('store_image')->index('store_image')->nullable()->onDelete('cascade');
                $table->string('location')->index('store_location')->nullable()->onDelete('cascade');
                $table->string('opening_hours')->index('store_opening_hours')->nullable()->onDelete('cascade');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};