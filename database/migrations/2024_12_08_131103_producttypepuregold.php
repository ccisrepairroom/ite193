<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTypesTablesForPuregold extends Migration
{
    public function up()
    {
        // Create Main Product Types table
        Schema::create('main_product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Create Sub Product Types table
        Schema::create('sub_product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Create Sub Sub Product Types table
        Schema::create('sub_sub_product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Create Other Types table
        Schema::create('other_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Create pivot table for Main Product Type and Sub Product Type
        Schema::create('main_product_type_sub_product_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_product_type_id')->constrained('main_product_types')->onDelete('cascade');
            $table->foreignId('sub_product_type_id')->constrained('sub_product_types')->onDelete('cascade');
            $table->timestamps();
        });

        // Create pivot table for Sub Product Type and Sub Sub Product Type
        Schema::create('sub_product_type_sub_sub_product_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_product_type_id')->constrained('sub_product_types')->onDelete('cascade');
            $table->foreignId('sub_sub_product_type_id')->constrained('sub_sub_product_types')->onDelete('cascade');
            $table->timestamps();
        });

        // Create pivot table for Sub Sub Product Type and Other Type
        Schema::create('sub_sub_product_type_other_type', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_sub_product_type_id')->constrained('sub_sub_product_types')->onDelete('cascade');
            $table->foreignId('other_type_id')->constrained('other_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_sub_product_type_other_type');
        Schema::dropIfExists('sub_product_type_sub_sub_product_type');
        Schema::dropIfExists('main_product_type_sub_product_type');
        Schema::dropIfExists('other_types');
        Schema::dropIfExists('sub_sub_product_types');
        Schema::dropIfExists('sub_product_types');
        Schema::dropIfExists('main_product_types');
    }
}
