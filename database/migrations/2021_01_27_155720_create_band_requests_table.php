<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('band_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_ID');
            $table->unsignedBigInteger('band_ID');
            $table->tinyInteger('accepted');
            $table->foreign('sender_ID')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('band_requests');
    }
}
