<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('user_id');
            $table->text('description');
            // available for check-ins.
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('checked_in_location')->nullable();
            $table->enum('status', ['pending', 'winner', 'disqualified'])->default('pending');
            $table->timestamps();
            $table->foreign('child_id')->references('id')->on('children')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('competition_id')->references('id')->on('competitions')->cascadeOnDelete();

        });
    }
}
