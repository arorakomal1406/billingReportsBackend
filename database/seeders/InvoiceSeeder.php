<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker; 
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        $invoices = [];
        $quotesToUpdate = [];

        // Fetch all accepted quotes
        $acceptedQuotes = DB::table('quotes')->where('quote_status', 'accepted')->get();

        foreach ($acceptedQuotes as $quote) {
            // Create invoice data
            $invoiceData = [
                'client_id' => $quote->client_id,
                'year_id' => $quote->year_id,
                'document_no' => $faker->unique()->numerify('INV-#####'),
                'amount' => $quote->amount,
                'quote_id' => $quote->id,
                'invoice_status' => 'pending', // or any default status
                'receipt_id' => null, // Assuming receipts will be linked later
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Add invoice data to invoices array
            $invoices[] = $invoiceData;
        }

        // Insert invoices and get the inserted IDs
        DB::table('invoices')->insert($invoices);

        // Fetch the inserted invoices with their IDs
        $insertedInvoices = DB::table('invoices')
            ->whereIn('quote_id', $acceptedQuotes->pluck('id'))
            ->get();

        // Prepare data for updating quotes with invoice IDs
        foreach ($insertedInvoices as $invoice) {
            $quotesToUpdate[] = [
                'id' => $invoice->quote_id,
                'invoice_id' => $invoice->id,
            ];
        }

        // Update the quotes table with the corresponding invoice IDs
        foreach ($quotesToUpdate as $update) {
            DB::table('quotes')->where('id', $update['id'])->update(['invoice_id' => $update['invoice_id']]);
        }
    }
}
