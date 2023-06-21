<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
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
                ProductImage::insert([
                    'product_id' => $product->id,
                    'image_url' => $faker->url(),
                    'image_alt' => $faker->company(),
                    'level' => rand(1, 3),
                    'created_at' => $faker->dateTime(),
                    'updated_at' => $faker->dateTime()
                ]);
            }
        }
    }
}