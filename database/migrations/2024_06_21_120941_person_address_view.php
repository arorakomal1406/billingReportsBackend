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
        // create view persons_address_view as
	    // select a.id,first_name,last_name,email,b.id as address_id,country,state,city from persons a join address b on a.id=b.perosn_id;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
