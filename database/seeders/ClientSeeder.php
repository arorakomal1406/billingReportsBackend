<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker; 
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        $clients = [];

        for ($i = 0; $i < 100; $i++) {
            $clients[] = [
                'name' => $faker->company,
                'opening_balance' => $faker->randomFloat(2, 100, 10000),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('clients')->insert($clients);

    }
}
