<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWishlistTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wishlist');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wishlist', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('product_variation_id')->index();
            $table->timestamps();
            $table->primary(['user_id', 'product_variation_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_variation_id')->references('id')->on('product_variations');
        });
    }
}
