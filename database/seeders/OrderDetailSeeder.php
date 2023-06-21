<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $productDetails = ProductDetail::all();
        $limit = 2;
        $orders = Order::all();
        // dd($products);
        foreach ($productDetails as $key => $productDetail) {
            foreach ($orders as $index => $order) {
                OrderDetail::insert([
                    'product_detail_id' => $productDetail->id,
                    'order_id' =>  $order->id,
                    'quantity' => rand(1, 10),
                    'price' => rand(100000, 200000),
                    'price_total' => rand(100000, 400000),
                    'note' => $faker->filePath(),
                    'created_at' => $faker->dateTime(),
                    'updated_at' => $faker->dateTime()
                ]);
            }
        }
    }
}
