<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_out', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('type');
            $table->string('senderAccount')->nullable();
            $table->string('transactionId')->nullable();
            $table->bigInteger('paymentId')->unsigned();
            $table->string('receiverCountry')->nullable();
            $table->decimal('amount', $precision = 20, $scale = 2);
            $table->char('currency')->nullable();
            $table->decimal('commissionAmount', $precision = 20, $scale = 2);
            $table->string('exchangeRate')->nullable();
            $table->string('billingAmount')->nullable();
            $table->string('billingFee')->nullable();
            $table->string('purposeCode')->nullable();
            $table->string('bankCode')->nullable();
            $table->json('paymentDetails')->nullable();
            $table->json('paymentFields')->nullable();
            $table->text('paymentError')->nullable();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('user_id')
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
        Schema::dropIfExists('pay_out');
    }
}
