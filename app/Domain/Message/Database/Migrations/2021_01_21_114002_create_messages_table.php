<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->text('body');
            $table->enum('type', ['push_notification', 'sms']);
            $table->unsignedBigInteger('competition_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('delay')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('competition_id')->references('id')->on('competitions')->cascadeOnDelete();
        });
    }
}
