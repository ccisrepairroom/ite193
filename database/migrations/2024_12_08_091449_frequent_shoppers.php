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
        Schema::create('frequent_shoppers', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_anonymous')->nullable()->default(0)->index('frequent_shopper_is_anonymous')->onDelete('cascade'); //0 for no
            $table->string('username')->index('frequent_shopper_username')->nullable()->onDelete('cascade');
            $table->decimal('total_spent',8,2)->index('frequent_shopper_total_spent')->nullable()->onDelete('cascade');
            $table->decimal('point_balance',8,2)->index('frequent_shopper_point_balance')->nullable()->onDelete('cascade');
            $table->date('membership_date')->index('frequent_shopper_membership_date')->nullable()->onDelete('cascade');
            $table->tinyInteger('status')->nullable()->default(0)->index('frequent_shopper_status')->onDelete('cascade'); //0 for inactive

            $table->unsignedBigInteger('user_id')->nullable()->index('frequent_shopper_user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');






            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequent_shoppers');
    }
};