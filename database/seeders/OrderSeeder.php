<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Voucher;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $users = User::all();
        $vouchers = Voucher::all();
        // dd($products);
        foreach ($users as $key => $user) {
            foreach ($vouchers as $index => $voucher) {
                Order::insert([
                    'user_id' => $user->id,
                    'voucher_id' => $voucher->id,
                    'name' => $faker->name,
                    'phone_number' => "023" . rand(0, 9) . "234" . rand(0, 9),
                    'address' => $faker->address,
                    'ship' => rand(20000, 50000),
                    'price_total' => rand(4000000, 5000000),
                    'price_payment' => rand(3000000, 4000000),
                    'payment_method' => rand(1, 2),
                    'status' => rand(1, 5),
                    'created_at' => $faker->dateTime(),
                    'updated_at' => $faker->dateTime()
                ]);
            }
        }
    }
}
