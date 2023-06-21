<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;
use Faker\Factory;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $limit = 10;
        // dd($fake->bloodType);
        for ($i = 0; $i < $limit; $i++) {
            Banner::insert([
                'image_url' => $faker->imageUrl,
                'image_alt' => $faker->bloodType,
                'location' => 1,
                'level' => $i + 1,
                'created_at' => $faker->date(),
                'updated_at' => $faker->date()
            ]);
        }
    }
}
