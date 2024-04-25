<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $caseData = [
            ['case_type' => 'Succession', 'initials' => 'suc', 'duration' => 10],
            ['case_type' => 'Divorce', 'initials' => 'div', 'duration' => 7],
            ['case_type' => 'Property Dispute', 'initials' => 'prop', 'duration' => 5],
            ['case_type' => 'Criminal Case', 'initials' => 'crim', 'duration' => 12],
            ['case_type' => 'Civil Case', 'initials' => 'civ', 'duration' => 7],
            ['case_type' => 'Family Case', 'initials' => 'fam', 'duration' => 7],
            ['case_type' => 'Land Dispute', 'initials' => 'land', 'duration' => 5],
            ['case_type' => 'Employment Dispute', 'initials' => 'empl', 'duration' => 5],
            ['case_type' => 'Commercial Dispute', 'initials' => 'comm', 'duration' => 5],
            ['case_type' => 'Constitutional Petition', 'initials' => 'const', 'duration' => 12],
            ['case_type' => 'Administrative Law Case', 'initials' => 'admin', 'duration' => 5],
            ['case_type' => 'Probate and Administration Case', 'initials' => 'prob', 'duration' => 10],
            ['case_type' => 'Environmental Law Case', 'initials' => 'env', 'duration' => 12],
            ['case_type' => 'Human Rights Case', 'initials' => 'hr', 'duration' => 12],
            ['case_type' => 'Tax Dispute', 'initials' => 'tax', 'duration' => 5],
            ['case_type' => 'Intellectual Property Case', 'initials' => 'ip', 'duration' => 10],
        ];

        $now = Carbon::now();

        $data = [];
        foreach ($caseData as $case) {
            $case['created_at'] = $now;
            $case['updated_at'] = $now;
            $data[] = $case;
        }
        DB::table('casetypes')->insert($data);
    }
}
