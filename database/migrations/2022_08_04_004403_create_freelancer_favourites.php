<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreelancerFavourites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freelancer_favourites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id')->unsigned();
            $table->bigInteger('freelancer_id')->unsigned();
            $table->timestamps();


            $table->foreign('employer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('freelancer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('freelancer_favourites');
    }
}
