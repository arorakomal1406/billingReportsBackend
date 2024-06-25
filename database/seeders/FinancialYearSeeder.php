<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $years = [
            ['year_series' => '2020-2021', 'created_at' => now(), 'updated_at' => now()],
            ['year_series' => '2021-2022', 'created_at' => now(), 'updated_at' => now()],
            ['year_series' => '2022-2023', 'created_at' => now(), 'updated_at' => now()],
            ['year_series' => '2023-2024', 'created_at' => now(), 'updated_at' => now()],
            ['year_series' => '2024-2025', 'created_at' => now(), 'updated_at' => now()],
            // Add more financial years as needed
        ];
        DB::table('financial_years')->insert($years);

    }
}
