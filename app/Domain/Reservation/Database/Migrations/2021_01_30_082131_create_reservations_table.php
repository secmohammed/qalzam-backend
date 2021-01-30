<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {

            $table->id();
            $table->float('price');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreign('creator_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreignId('accommodation_id')->constrained()->onDelete('cascade');
            $table->index(['accommodation_id', 'user_id', ' creator_id']);
            $table->timestamps();

        });
    }
}
