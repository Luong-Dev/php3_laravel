<?php

namespace Database\Seeders;

use App\Models\ProductAttributeCategory;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductAttributeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $limit = 10;
        for ($i = 0; $i < $limit; $i++) {
            ProductAttributeCategory::insert([
                'name' => $faker->name,
                'description' => $faker->text,
                'created_at' => $faker->date(),
                'updated_at' => $faker->date()
            ]);
        }
    }
}
