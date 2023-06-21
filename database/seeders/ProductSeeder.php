<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $productCategories = ProductCategory::all();
        // dd($productCategories);
        $limit = 2;

        foreach ($productCategories as $key => $productCategory) {
            for ($i = 0; $i < $limit; $i++) {
                Product::insert([
                    'product_category_id' => $productCategory->id,
                    'name' => $faker->name,
                    'short_description' => $faker->text,
                    'long_description' => $faker->text,
                    'views' => $faker->randomNumber(),
                    'created_at' => $faker->dateTime(),
                    'updated_at' => $faker->dateTime()
                ]);
            }
        }
    }
}
