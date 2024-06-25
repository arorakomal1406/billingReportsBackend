<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        $quotes = [];
        $clients = DB::table('clients')->pluck('id')->toArray(); // Get all client IDs
        $financialYears = DB::table('financial_years')->pluck('id')->toArray(); // Get all financial year IDs

        for ($i = 0; $i < 1000; $i++) {
            $quotes[] = [
                'client_id' => $faker->randomElement($clients),
                'year_id' => $faker->randomElement($financialYears),
                'document_no' => $faker->unique()->numerify('DOC-#####'),
                'amount' => $faker->randomFloat(2, 100, 10000),
                'invoice_id' => null, // Assuming invoices will be linked later
                'quote_status' => $faker->randomElement(['pending', 'accepted', 'rejected']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('quotes')->insert($quotes);
    }
}
