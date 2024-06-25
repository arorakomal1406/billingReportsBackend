<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW invoices_status AS
            SELECT
                i.id AS invoice_id,
                i.client_id,
                i.year_id,
                i.document_no,
                i.amount,
                CASE
                    WHEN i.invoice_status = 'paid' THEN 'paid'
                    WHEN i.invoice_status = 'partially-paid' THEN 'partially-paid'
                    ELSE 'not paid'
                END AS status
            FROM
                invoices i
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS invoices_status');
    }
};
