<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(JudgeSeeder::class);
        $this->call(CourtSeeder::class);
        $this->call(CaseSeeder::class);
        $this->call(FileSeeder::class);
        
    }
}
