<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeCategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $productAttributeCategories = ProductAttributeCategory::all();
        // dd($productAttributeCategories);
        $limit = 2;

        foreach ($productAttributeCategories as $key => $productAttributeCategory) {
            for ($i = 0; $i < $limit; $i++) {
                ProductAttribute::insert([
                    'product_attribute_category_id' => $productAttributeCategory->id,
                    'name' => $faker->name,
                    'description_value' => $faker->text,
                    'created_at' => $faker->dateTime(),
                    'updated_at' => $faker->dateTime()
                ]);
            }
        }
    }
}
