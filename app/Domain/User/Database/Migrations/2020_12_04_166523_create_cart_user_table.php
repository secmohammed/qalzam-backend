<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartUserTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_user');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('product_variation_id')->index();
            $table->unsignedBigInteger('quantity')->default(1);
            $table->timestamps();
            $table->primary(['user_id', 'product_variation_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_variation_id')->references('id')->on('product_variations');
        });
    }
}
