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
        Schema::create('order_details', function (Blueprint $table) {

            $table->primary(['product_detail_id', 'order_id']);
            $table->integer('product_detail_id');
            $table->integer('order_id');
            $table->integer('quantity');
            $table->double('price', 10, 2);
            $table->double('price_total', 10, 2);
            $table->text('note')->nullable($value = true);
            $table->timestamp('deleted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
