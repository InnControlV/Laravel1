<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Jenssegers\Mongodb\Schema\Blueprint as MongoBlueprint;
use Illuminate\Support\Facades\Schema;

class News extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('short_description');
            $table->longText('details');
            $table->string('language');
            $table->string('location');
            $table->date('date');
            $table->time('time');
            $table->string('refer_from')->nullable(); // Inshorts, Newsify
            $table->string('link')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('favourite')->default(false);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('News');
    }
}
