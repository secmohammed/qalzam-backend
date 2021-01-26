<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {

            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();

        });
        Schema::create('ingredient_product', function (Blueprint $table) {
            $table->unsignedBigInteger('ingredient_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });
    }
}
