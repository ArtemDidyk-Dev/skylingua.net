<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('menu_id')->unsigned();
            $table->bigInteger('language')->unsigned();
            $table->string('label',255)->nullable();
            $table->string('link',255)->nullable();
            $table->timestamps();


            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade');


            $table->foreign('language')
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
        Schema::dropIfExists('menu_translations');
    }
}
