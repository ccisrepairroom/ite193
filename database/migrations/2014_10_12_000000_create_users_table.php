<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index('user_name')->nullable()->onDelete('cascade');
            $table->string('email')->unique()->index('user_email')->nullable()->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable()->onDelete('cascade');
            //$table->unsignedBigInteger('role_id'); 
            //$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade'); 
            $table->string('profile_image')->index('user_profile_image')->nullable()->onDelete('cascade');
            $table->string('contact_number')->index('user_contact_number')->nullable()->onDelete('cascade');
            $table->tinyInteger('is_frequent_shopper')->nullable()->default(0)->index('user_is_frequent_shopper')->onDelete('cascade'); 
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
