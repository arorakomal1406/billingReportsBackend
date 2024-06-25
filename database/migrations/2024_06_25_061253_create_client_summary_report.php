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
        // Create TotalInvoiced function
        DB::unprepared("
            CREATE FUNCTION TotalInvoiced(client_id INT) RETURNS DECIMAL(10, 2)
            BEGIN
                DECLARE total DECIMAL(10, 2);
                SELECT IFNULL(SUM(i.amount), 0)
                INTO total
                FROM invoices i
                WHERE i.client_id = client_id;
                RETURN total;
            END
        ");

        // Create TotalPaid function
        DB::unprepared("
            CREATE FUNCTION TotalPaid(client_id INT) RETURNS DECIMAL(10, 2)
            BEGIN
                DECLARE total DECIMAL(10, 2);
                SELECT IFNULL(SUM(r.amount), 0) INTO total
                FROM invoices i
                JOIN receipts r ON i.id = r.invoice_id
                WHERE i.client_id = client_id;
                RETURN total;
            END
        ");

        // Create BalanceDue function
        DB::unprepared("
            CREATE FUNCTION BalanceDue(client_id INT) RETURNS DECIMAL(10, 2)
            BEGIN
                RETURN TotalInvoiced(client_id) - TotalPaid(client_id);
            END
        ");

        // Create GetClientSummary procedure
        DB::unprepared("
            CREATE PROCEDURE GetClientSummary()
            BEGIN
                SELECT 
                    c.id AS client_id,
                    c.name AS client_name,
                    TotalInvoiced(c.id) AS total_invoiced,
                    TotalPaid(c.id) AS total_paid,
                    BalanceDue(c.id) AS balance_due
                FROM 
                    clients c;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop GetClientSummary procedure
        DB::unprepared("
            DROP PROCEDURE IF EXISTS GetClientSummary;
        ");

        // Drop BalanceDue function
        DB::unprepared("
            DROP FUNCTION IF EXISTS BalanceDue;
        ");

        // Drop TotalPaid function
        DB::unprepared("
            DROP FUNCTION IF EXISTS TotalPaid;
        ");

        // Drop TotalInvoiced function
        DB::unprepared("
            DROP FUNCTION IF EXISTS TotalInvoiced;
        ");    
    }
};
