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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();

            $table->integer('product_id');
            $table->double('regular_price', 10, 2);
            $table->double('sale_price', 10, 2)->nullable($value = true);
            $table->integer('quantity');
            $table->tinyInteger('status')->default(1)->comment('1: còn hàng; 2: hàng đang về; 3: tạm hết ;4: ngưng bán');
            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
