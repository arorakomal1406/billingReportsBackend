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
        //
        Schema::create('address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            // Add other relevant person fields as needed (e.g., phone number, birthdate)
            $table->timestamps();
            $table->biginteger('perosn_id')->unsigned()->nullable();
            $table->foreign('perosn_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('address');

    }
};
