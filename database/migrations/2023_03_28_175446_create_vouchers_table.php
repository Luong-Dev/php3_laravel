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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('name',60);
            $table->string('code',20);
            $table->text('description')->nullable($value = true);
            $table->tinyInteger('percent_value')->default(0)->comment("Mặc định sale 0 %");
            $table->double('money_value',10,2)->default(0)->comment("nhập bao nhiêu trừ bấy nhiêu");
            $table->double('order_value_total',10,2)->default(0);
            $table->integer('quantity')->default(-10)->comment("Không nhập thì mặc định là -10, là dùng không giới hạn");
            $table->integer('quantity_used')->default(0)->comment("Số lượng đã được sử dụng");
            $table->dateTime('start_time')->useCurrent();
            $table->dateTime('end_time');
            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
