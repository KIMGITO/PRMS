<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JudgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('judges')->insert([
                'name' => $faker->unique()->name,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
