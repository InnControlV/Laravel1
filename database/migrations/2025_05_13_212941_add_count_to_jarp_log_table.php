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
        Schema::table('jarp_log', function (Blueprint $table) {
            $table->unsignedInteger('count')->default(0);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('jarp_log', function (Blueprint $table) {
            $table->dropColumn('count');
        });
    }
};
