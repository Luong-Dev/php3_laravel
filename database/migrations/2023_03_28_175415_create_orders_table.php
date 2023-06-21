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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->nullable($value = true);
            $table->integer('voucher_id');
            $table->string('name',60);
            $table->string('phone_number',15);
            $table->text('address');
            $table->double('ship',8,2);
            $table->double('price_total',10,2);
            $table->double('price_payment',10,2);
            $table->tinyInteger('payment_method')->comment("1: thanh toán khi nhận hàng, 2: online");
            $table->tinyInteger('status')->default(1)->comment("mặc định 1 là chờ xác nhận, 2: đang chuẩn bị, 3: đang giao, 4: giao thành công, 5: bị hủy");
            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
