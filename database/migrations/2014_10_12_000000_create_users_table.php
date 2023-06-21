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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('last_name', 30);
            $table->string('first_name', 20);
            $table->string('phone_number', 15)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birth_of_date')->nullable();
            $table->boolean('gender')->nullable()->comment("1: nam, 2: nữ");
            $table->string('address')->nullable();
            $table->tinyInteger('role')->default(2)->comment("1: super admin, 2: admin, 5: user");
            $table->tinyInteger('status')->default(1)->comment("1: hoạt động, 2: bị khóa");
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
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
