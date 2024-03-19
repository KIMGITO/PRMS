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
    { {
            $caseData = [
                'Succession' => ['initials' => 'suc', 'retention_time' => '10'],
                'Divorce' => ['initials' => 'div', 'retention_time' => '7'],
                'Property Dispute' => ['initials' => 'prop', 'retention_time' => '5'],
                'Criminal Case' => ['initials' => 'crim', 'retention_time' => '12'],
                'Civil Case' => ['initials' => 'civ', 'retention_time' => '7'],
                'Family Case' => ['initials' => 'fam', 'retention_time' => '7'],
                'Land Dispute' => ['initials' => 'land', 'retention_time' => '5'],
                'Employment Dispute' => ['initials' => 'empl', 'retention_time' => '5'],
                'Commercial Dispute' => ['initials' => 'comm', 'retention_time' => '5'],
                'Constitutional Petition' => ['initials' => 'const', 'retention_time' => '12'],
                'Administrative Law Case' => ['initials' => 'admin', 'retention_time' => '5'],
                'Probate and Administration Case' => ['initials' => 'prob', 'retention_time' => '10'],
                'Environmental Law Case' => ['initials' => 'env', 'retention_time' => '12'],
                'Human Rights Case' => ['initials' => 'hr', 'retention_time' => '12'],
                'Tax Dispute' => ['initials' => 'tax', 'retention_time' => '5'],
                'Intellectual Property Case' => ['initials' => 'ip', 'retention_time' => '10'],
            ];

            $now = Carbon::now();

            foreach ($caseData as $caseType => $data) {
                DB::table('casetypes')->insert([
                    'case_type' => $caseType,
                    'initials' => $data['initials'],
                    'duration' => $data['retention_time'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
