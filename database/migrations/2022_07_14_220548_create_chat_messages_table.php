<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('chat_id')->unsigned();
            $table->bigInteger('user_from')->unsigned();
            $table->bigInteger('user_to')->unsigned();
            $table->text('message')->nullable();
            $table->text('file')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('chat_id')
                ->references('id')
                ->on('chats')
                ->onDelete('cascade');

            $table->foreign('user_from')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('user_to')
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
        Schema::dropIfExists('chat_messages');
    }
}
