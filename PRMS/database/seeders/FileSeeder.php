<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Faker\Factory as Faker;
use Carbon\Carbon;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $faker = Faker::create();

    $filingStartDate = '2018-01-01';
    $filingEndDate = '2024-02-29';
    $rulingEndDate = $filingEndDate;

    $data = [];

    for ($i = 0; $i < 20; $i++) {
        $caseNumber = $faker->unique()->numberBetween(100, 999);
        $caseYear = $faker->numberBetween(2018, 2024);

        $filingDate = $faker->dateTimeBetween($filingStartDate, $filingEndDate);
        $rulingDate = $faker->optional()->dateTimeBetween($filingDate->format('Y-m-d'), $rulingEndDate);

        $numPlaintiffs = $faker->numberBetween(1, 3);
        $numDefendants = $faker->numberBetween(1, 3);

        $plaintiffs = $this->generateNames($faker, $numPlaintiffs);
        $defendants = $this->generateNames($faker, $numDefendants);

        $casetypeId = $faker->numberBetween(1, 5);
        $judgeId = $faker->numberBetween(1, 5);
        $courtId = $faker->numberBetween(1, 5);
        $caseDescription = $faker->paragraph;

        $data[] = [
            'case_number' => $caseNumber . '/' . $caseYear,
            'casetype_id' => $casetypeId,
            'filing_date' => $filingDate,
            'ruling_date' => $rulingDate,
            'plaintiffs' => $plaintiffs,
            'defendants' => $defendants,
            'judge_id' => $judgeId,
            'court_id' => $courtId,
            'disposal_date'=> Carbon::now()->addYears(12),
            'case_description' => $caseDescription,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    DB::table('files')->insert($data);
}

    // Helper method to generate names
    private function generateNames($faker, $numNames)
    {
        $names = [];
        for ($i = 0; $i < $numNames; $i++) {
            $names[] = $faker->firstName . ' ' . $faker->lastName;
        }
        return implode(', ', $names);
    }
}
