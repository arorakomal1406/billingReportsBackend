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
            CREATE VIEW receipt_details AS
                SELECT
                    r.id AS receipt_id,
                    c.name AS client_name,
                    r.client_id,
                    r.year_id,
                    r.document_no AS receipt_document_no,
                    SUM(r.amount) AS receipt_amount,
                    i.id AS invoice_id,
                    i.document_no AS invoice_document_no,
                    SUM(i.amount) AS invoice_amount,
                    (SUM(i.amount) - COALESCE(SUM(r.amount), 0)) AS balance_due
                FROM
                    receipts r
                LEFT JOIN
                    invoices i ON r.invoice_id = i.id
                LEFT JOIN
                    clients c ON r.client_id = c.id
                GROUP BY
                    r.id, i.id, r.client_id, r.year_id, r.document_no, i.document_no, c.name
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS receipt_details');
    }
};
