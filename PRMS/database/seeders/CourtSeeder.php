<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courtLevels = [
            'Supreme Court',
            'Court of Appeal',
            'High Court',
            'Employment and Labour Court',
            'Environment and Land Court',
            'Magistrates Courts',
            'Kadhis Court',
            // Add more court levels as needed
        ];

        foreach ($courtLevels as $level) {
            DB::table('courts')->insert([
                'name' => $level,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
