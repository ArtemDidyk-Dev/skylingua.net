<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagePhrasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_phrases', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->tinyInteger('editor')->default(0);
            $table->bigInteger('language_group_id')->unsigned();
            $table->timestamps();

            $table->foreign('language_group_id')
                ->references('id')
                ->on('language_groups')
                ->onDelete('cascade');

            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_phrases');
    }
}
