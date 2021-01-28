<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BandLeden extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('band_ledens', function (Blueprint $table) {
            $table->unsignedBigInteger('band_ID');
            $table->unsignedBigInteger('user_ID');
            $table->unique(['band_ID', 'user_ID']);
            $table->foreign('user_ID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('band_ID')->references('band_ID')->on('bands')->onDelete('cascade');
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
        //
    }
}
