<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectHireds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_hireds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('freelancer_id')->unsigned();
            $table->bigInteger('project_id')->unsigned()->unique();
            $table->decimal('price')->unsigned()->default(0.00);
            $table->bigInteger('hours')->unsigned()->default(0);
            $table->text('letter')->nullable();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->timestamps();


            $table->foreign('freelancer_id')
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
        Schema::dropIfExists('project_hireds');
    }
}
