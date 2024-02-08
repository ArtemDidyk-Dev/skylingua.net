<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_translations', function (Blueprint $table) {
//            $table->id();
            $table->bigInteger('setting_id')->unsigned();
            $table->bigInteger('language_id')->unsigned();
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('setting_id')
                ->references('id')
                ->on('settings')
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
        Schema::dropIfExists('settings_translations');
    }
}
