<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;
use Faker\Factory as Faker;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $faker = Faker::create();

    $departments = [
        "Civil Registry", "Criminal Registry", "Family Registry",
        "Environmental and Land Registry", "Commercial Registry",
        "Probate and Administration Registry",
        "Labour and Employment Registry", "Juvenile Registry",
        "Constitutional and Human Rights Registry",
    ];

    shuffle($departments); // Randomize the order of departments

    $selectedDepartments = array_slice($departments, 0, 5); // Select the first 5 departments

    foreach ($selectedDepartments as $department) {
        Department::create(['name' => $department]);
    }
}
}
