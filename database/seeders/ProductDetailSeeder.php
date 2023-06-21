<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductDetail;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $products = Product::all();
        $limit = 2;
        foreach ($products as $key => $product) {
            for ($i = 0; $i < $limit; $i++) {
                ProductDetail::insert([
                    'product_id' => $product->id,
                    'regular_price' => rand(10000, 2000000),
                    'sale_price' => rand(10000, 2000000),
                    'quantity' => rand(1, 150),
                    'status' => rand(1,4),
                    'created_at' => $faker->dateTime(),
                    'updated_at' => $faker->dateTime()
                ]);
            }
        }
    }
}
