<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id')->unsigned();
            $table->bigInteger('freelancer_id')->unsigned();
            $table->bigInteger('project_id')->unsigned();
            $table->tinyInteger('type');
            $table->decimal('amount', $precision = 8, $scale = 2);
            $table->integer('currency');
            $table->string('orderId')->nullable();
            $table->integer('code')->nullable();
            $table->tinyInteger('status')->default(0);
            // $table->timestamps('paid_on')->nullable();
            // $table->datetime('paid_on')->nullable();
            $table->timestamps();


            $table->foreign('employer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('freelancer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // $table->foreign('project_id')
            //     ->references('id')
            //     ->on('projects')
            //     ->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pays');
    }
}
