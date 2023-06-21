<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Factory::create();
        $limit = 10;
        for ($i = 0; $i < $limit; $i++) {
            User::insert([
                'last_name' => $faker->lastName,
                'first_name' => $faker->firstName,
                'email' => $faker->unique()->email,
                'phone_number' => $faker->phoneNumber,
                'password' => $faker->password,
                'birth_of_date' => $faker->date(),
                'gender' => rand(1, 2),
                'address' => $faker->address(),
                'role' => array_rand([2, 5], 1),
                'status' => 1,
                'created_at' => $faker->date(),
                'updated_at' => $faker->date()
            ]);
        }
    }
}
