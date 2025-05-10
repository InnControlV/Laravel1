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
        Schema::create('shoppings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->string('media')->nullable(); // image or video
            $table->string('link_url')->nullable();
            $table->string('author')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->date('create_date');
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->boolean('is_delete')->default(false);
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoppings');
    }
};
