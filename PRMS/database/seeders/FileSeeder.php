<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Faker\Factory as Faker;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 6; $i++) {
            $uniqueValidator = Validator::make([
                'case_number' => $faker->unique()->numberBetween(100, 999),
                'case_year' => $faker->numberBetween(2018, 2024)
            ], [
                'caseNumber' => [
                    'required',
                    Rule::unique('files')->where(function ($query) use ($faker) {
                        return $query->where('casenumber', $faker->numberBetween(2018, 2024));
                    })
                ]
            ]);

            // Ensure unique combination of case number and year
            while ($uniqueValidator->fails()) {
                $uniqueValidator = Validator::make([
                    'case_number' => $faker->unique()->numberBetween(100, 999),
                    'filing_date' => $faker->numberBetween(2018, 2024)
                ], [
                    'case_number' => [
                        'required',
                        Rule::unique('files')->where(function ($query) use ($faker) {
                            return $query->where('filing_date', $faker->numberBetween(2018, 2024));
                        })
                    ]
                ]);
            }

            $caseNumber = $uniqueValidator->valid()['case_number'];
            $caseYear = $uniqueValidator->valid()['filing_date'];

            // Generate filing date between January 1, 2018, and February 29, 2024
            $filingStartDate = '2018-01-01';
            $filingEndDate = '2024-02-29';
            $filingDate = $faker->dateTimeBetween($filingStartDate, $filingEndDate);

            // Generate end date for ruling date to ensure it's after filing date
            $rulingStartDate = $filingDate->format('Y-m-d');
            $rulingEndDate = $filingEndDate;
            $rulingDate = $faker->optional()->dateTimeBetween($rulingStartDate, $rulingEndDate);

            // Generate random names for plaintiffs and defendants
            $numPlaintiffs = $faker->numberBetween(1, 3); // Generate up to 3 plaintiffs
            $numDefendants = $faker->numberBetween(1, 3); // Generate up to 3 defendants

            $plaintiffs = $this->generateNames($faker, $numPlaintiffs);
            $defendants = $this->generateNames($faker, $numDefendants);

            // Generate random data for other fields
            $casetypeId = $faker->numberBetween(1, 16);
            $judgeId = $faker->numberBetween(1, 20);
            $courtId = $faker->numberBetween(1, 7);
            $caseDescription = $faker->optional()->paragraph;

            DB::table('files')->insert([
                'case_number' => $caseNumber . '/' . $caseYear,
                'casetype_id' => $casetypeId,
                'filing_date' => $filingDate,
                'ruling_date' => $rulingDate,
                'plaintiffs' => $plaintiffs,
                'defendants' => $defendants,
                'judge_id' => $judgeId,
                'court_id' => $courtId,
                'case_description' => $caseDescription,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
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
