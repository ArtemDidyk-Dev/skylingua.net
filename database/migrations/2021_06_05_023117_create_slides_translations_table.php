<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides_translations', function (Blueprint $table) {
            $table->bigInteger('slide_id')->unsigned();
            $table->bigInteger('language_id')->unsigned();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('button_url',255)->nullable();
            $table->string('button_name',255)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('slide_id')
                ->references('id')
                ->on('slides')
                ->onDelete('cascade');


            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
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
        Schema::dropIfExists('slides_translations');
    }
}
