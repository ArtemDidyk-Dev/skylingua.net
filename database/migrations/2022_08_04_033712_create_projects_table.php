<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id')->unsigned();
            $table->bigInteger('freelancer_id')->unsigned();
            $table->bigInteger('country_id')->unsigned()->nullable()->default(0);
            $table->string('name')->nullable();
            $table->tinyInteger('price_type')->nullable();
            $table->decimal('price')->unsigned()->nullable()->default(0.00);
            $table->dateTime('deadline')->nullable();
            $table->dateTime('hired')->nullable();
            $table->dateTime('completed')->nullable();
            $table->text('document')->nullable();
            $table->json('links')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->unsigned();
            $table->tinyInteger('approve')->unsigned()->nullable()->default(1);
            $table->timestamps();

            $table->foreign('employer_id')
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
        Schema::dropIfExists('projects');
    }
}
