<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
{
    $faker = Faker::create();
    $data = [];

    for ($i = 0; $i < 5; $i++) {
        $workId = 'P' . $faker->randomElement([$faker->numerify('###'), $faker->numerify('####')]) . '/' . $faker->numerify('####');

        $data[] = [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'phone' => $faker->phoneNumber,
            'national_id' => $faker->unique()->numerify('########'),
            'work_id' => $workId,
            'role' => $faker->randomElement(['user', 'admin']),
            'verified' => 1,
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    DB::table('users')->insert($data);
}
}