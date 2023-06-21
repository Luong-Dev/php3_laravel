<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $limit = 10;
        for ($i = 0; $i < $limit; $i++) {
            Voucher::insert([
                'name' => $faker->jobTitle(),
                'code' => $faker->countryCode(),
                'description' => $faker->word,
                'percent_value' => rand(1, 100),
                'money_value' => rand(100000, 123123),
                'order_value_total' => rand(100000, 123123),
                'quantity' => -10,
                'quantity_used' => 0,
                'start_time' => $faker->dateTime(),
                'end_time' => $faker->dateTime(),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime()
            ]);
        }
    }
}