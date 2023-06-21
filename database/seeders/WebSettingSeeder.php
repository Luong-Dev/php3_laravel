<?php

namespace Database\Seeders;

use App\Models\WebSetting;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WebSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $limit = 10;
        for ($i = 0; $i < $limit; $i++) {
            WebSetting::insert([
                'name' => $faker->name,
                'value' => $faker->name,
                'description' => $faker->text,
                'created_at' => $faker->date(),
                'updated_at' => $faker->date()
            ]);
        }
    }
}
