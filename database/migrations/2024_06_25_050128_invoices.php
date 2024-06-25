<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients');
            $table->foreignId('year_id')->constrained('financial_years');
            $table->string('document_no');
            $table->decimal('amount', 10, 2);
            $table->unsignedBigInteger('quote_id')->nullable();
            $table->string('invoice_status');
            $table->unsignedBigInteger('receipt_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
?>