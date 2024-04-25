<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $purposes = [
            [
                'purpose' => 'Filing a Lawsuit',
                'supervised' => true,
                'description' => 'Requesting a case file for filing a lawsuit.',
            ],
            [
                'purpose' => 'Legal Research',
                'supervised' => false,
                'description' => 'Requesting a case file for legal research purposes.',
            ],
            [
                'purpose' => 'Case Review',
                'supervised' => false,
                'description' => 'Requesting a case file for review purposes.',
            ],
            [
                'purpose' => 'Appeal Process',
                'supervised' => true,
                'description' => 'Requesting a case file for the appeal process.',
            ],
            [
                'purpose' => 'Evidence Examination',
                'supervised' => false,
                'description' => 'Requesting a case file for examination of evidence.',
            ],
            [
                'purpose' => 'Legal Consultation',
                'supervised' => false,
                'description' => 'Requesting a case file for legal consultation.',
            ],
            [
                'purpose' => 'Settlement Negotiation',
                'supervised' => true,
                'description' => 'Requesting a case file for settlement negotiation.',
            ],
        ];
        
        foreach($purposes as $purpose){
            DB::table('purposes')->insert($purpose);
        }
    }
}
