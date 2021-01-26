<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }

    /**

     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {

            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedInteger('_lft')->default(0)->index();
            $table->unsignedInteger('_rgt')->default(0)->index();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('type', ['country', 'city', 'district', 'zone']);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('parent_id')->references('id')->on('locations')->cascadeOnDelete();

        });

    }
}
