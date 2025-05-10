<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->string('author')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('rating')->nullable();
            $table->date('release_date')->nullable();
            $table->longText('description')->nullable();
            $table->string('language')->nullable();
            $table->string('other_language')->nullable();

            // Newly added fields
            $table->string('url')->nullable();          // For trailer or official site
            $table->string('link')->nullable();         // For external details
            $table->string('movie_type')->nullable();   // e.g., Action, Comedy, Drama

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
