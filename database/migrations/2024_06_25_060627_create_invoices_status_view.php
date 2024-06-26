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
                c.name AS client_name, -- Adding client name from clients table
                i.year_id,
                f.year_series,
                i.document_no,
                i.amount,
                CASE
                    WHEN i.invoice_status = 'paid' THEN 'paid'
                    WHEN i.invoice_status = 'partially-paid' THEN 'partially-paid'
                    ELSE 'not paid'
                END AS status
            FROM
                invoices i
            JOIN
                clients c ON i.client_id = c.id -- Joining invoices with clients to get client name
            JOIN
                financial_years f ON i.year_id = f.id; -- Joining invoices with financial_year to get year_series

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
