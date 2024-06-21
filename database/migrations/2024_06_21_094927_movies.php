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
        Schema::create('movies', function (Blueprint $table) {
            // $table->bigIncrements('id');
            $table->bigInteger('id')->default(0);
            $table->boolean('adult')->default(false);
            $table->json('belongs_to_collection')->nullable();
            $table->bigInteger('budget')->nullable();
            $table->json('generics')->nullable();
            $table->text('homepage')->default(""); // Optional meta description
            $table->bigInteger('imdb_id')->default(0);
            $table->string("original_language")->default("");
            $table->string("original_title")->default("");
            $table->text('overview')->default(""); // Optional meta description
            $table->double('popularity')->nullable();  // Optional, depending on your needs
            $table->string('poster_path')->nullable();  // Optional, depending on your needs
            $table->json('production_companies')->nullable();
            $table->date('release_date')->nullable();  // Allow null for movies not yet released
            $table->double('revenue')->nullable();  // Optional, depending on your needs
            $table->integer('runtime')->nullable();
            $table->json('spoken_languages')->nullable();
            $table->string('status')->nullable();  // Optional, depending on your needs
            $table->text('tagline')->default(""); // Optional meta description
            $table->string('title')->nullable();  // Optional, depending on your needs
            
            $table->boolean('video')->default(false);
            $table->float('vote_average')->default(0.00);
            $table->integer('vote_count')->default(0);

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('movies');

    }
};
