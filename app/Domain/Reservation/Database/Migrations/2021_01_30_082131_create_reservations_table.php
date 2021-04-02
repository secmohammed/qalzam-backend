<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->float('price')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users', 'id')->onDelete('cascade');
            $table->enum('status', ['upcoming', 'done', 'delivered'])->default('upcoming');
            $table->string('notes')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->foreignId('accommodation_id')->constrained()->onDelete('cascade');
            $table->index(['accommodation_id', 'user_id', 'creator_id']);
            $table->timestamps();

        });
    }
}
