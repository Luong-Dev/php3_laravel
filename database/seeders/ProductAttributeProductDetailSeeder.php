<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeProductDetail;
use App\Models\ProductDetail;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Factory::create();
        $productDetails = ProductDetail::all();
        $productAttributes = ProductAttribute::all();
        // dd($products);
        foreach ($productDetails as $key => $productDetail) {
            foreach ($productAttributes as $index => $productAttribute) {
                ProductAttributeProductDetail::insert([
                    'product_attribute_id' => $productAttribute->id,
                    'product_detail_id' => $productDetail->id,
                    'created_at' => $faker->dateTime(),
                    'updated_at' => $faker->dateTime()
                ]);
            }
        }
    }
}
