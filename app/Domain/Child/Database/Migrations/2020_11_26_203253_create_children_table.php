<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('children');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->date('birthdate');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('national_id')->unique();
            $table->enum('relation', ['son', 'daughter', 'grand-son', 'grand-daughter', 'nephew']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('gender', ['male', 'female']);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }
}
