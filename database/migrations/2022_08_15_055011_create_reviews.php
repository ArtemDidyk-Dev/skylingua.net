<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from')->unsigned();
            $table->bigInteger('to')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->decimal('rating')->unsigned()->default(0.00);
            $table->text('review')->nullable();
            $table->timestamps();

            $table->foreign('from')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('to')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
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
        Schema::dropIfExists('reviews');
    }
}
