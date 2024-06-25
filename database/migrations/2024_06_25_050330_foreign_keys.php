<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('set null');
            $table->foreign('receipt_id')->references('id')->on('receipts')->onDelete('set null');
        });

        Schema::table('receipts', function (Blueprint $table) {
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['quote_id']);
            $table->dropForeign(['receipt_id']);
        });

        Schema::table('receipts', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
        });
    }
}
?>