<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {

            $table->id();
            $table->text('name');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('min_age');
            $table->integer('max_age');
            $table->unsignedBigInteger('location_id')->index();
            $table->enum('gender', ['male', 'female', 'both']);
            $table->enum('type', ['video', 'image', 'check-in']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('user_id');
            $table->enum('featured', ['featured', 'normal'])->default('normal');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
        });
        Schema::create('child_competition', function (Blueprint $table) {
            $table->unsignedBigInteger('competition_id');
            $table->unsignedBigInteger('child_id');
            $table->primary(['competition_id', 'child_id']);
            $table->foreign('competition_id')->references('id')->on('competitions')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
        });
    }
}
