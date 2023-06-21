<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\ProductDetail;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $productDetails = ProductDetail::all();
        $limit = 2;
        $users = User::all();
        // dd($products);
        foreach ($productDetails as $key => $productDetail) {
            foreach ($users as $index => $user) {
                Cart::insert([
                    'product_detail_id' => $productDetail->id,
                    'user_id' => $user->id,
                    'quantity' => rand(1, 10),
                    'created_at' => $faker->dateTime(),
                    'updated_at' => $faker->dateTime()
                ]);
            }
        }
    }
}
