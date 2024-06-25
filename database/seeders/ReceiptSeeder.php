<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker; 
use Illuminate\Support\Facades\DB;

class ReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();
        $receipts = [];
        $invoicesToUpdate = [];

        // Fetch 200 invoices to create receipts for
        $invoices = DB::table('invoices')->limit(200)->get();

        $fullyPaidCount = 0;
        $partiallyPaidCount = 0;

        foreach ($invoices as $invoice) {
            // Determine the amount to be paid in the receipt
            if ($fullyPaidCount < 100) {
                $amountPaid = $invoice->amount; // Full amount
                $invoiceStatus = 'paid';
                $fullyPaidCount++;
            } elseif ($partiallyPaidCount < 100) {
                $amountPaid = $faker->randomFloat(2, 1, $invoice->amount - 1); // Random amount less than the invoice amount
                $invoiceStatus = 'partially-paid';
                $partiallyPaidCount++;
            } else {
                break; // We have created 100 fully paid and 100 partially paid receipts
            }

            // Create receipt data
            $receiptData = [
                'client_id' => $invoice->client_id,
                'year_id' => $invoice->year_id,
                'document_no' => $faker->unique()->numerify('RCT-#####'),
                'amount' => $amountPaid,
                'invoice_id' => $invoice->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Add receipt data to receipts array
            $receipts[] = $receiptData;

            // Prepare data for updating invoices with receipt IDs and statuses
            $invoicesToUpdate[] = [
                'id' => $invoice->id,
                'invoice_status' => $invoiceStatus,
            ];
        }

        // Insert receipts and get the inserted IDs
        DB::table('receipts')->insert($receipts);

        // Fetch the inserted receipts with their IDs
        $insertedReceipts = DB::table('receipts')
            ->whereIn('invoice_id', $invoices->pluck('id'))
            ->get();

        // Prepare data for updating invoices with receipt IDs
        foreach ($insertedReceipts as $receipt) {
            $invoiceId = $receipt->invoice_id;
            foreach ($invoicesToUpdate as &$update) {
                if ($update['id'] == $invoiceId) {
                    $update['receipt_id'] = $receipt->id;
                    break;
                }
            }
        }

        // Update the invoices table with the corresponding receipt IDs and statuses
        foreach ($invoicesToUpdate as $update) {
            DB::table('invoices')->where('id', $update['id'])->update([
                'receipt_id' => $update['receipt_id'],
                'invoice_status' => $update['invoice_status'],
            ]);
        }
    }
}
