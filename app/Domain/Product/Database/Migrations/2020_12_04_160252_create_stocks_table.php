<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('quantity');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('product_variation_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamps();
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
}
