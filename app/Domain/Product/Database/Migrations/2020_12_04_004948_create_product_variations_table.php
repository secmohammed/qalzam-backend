<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variations');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('name');
            $table->jsonb('details')->nullable();
            $table->unsignedBigInteger('user_id')->index();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->integer('price')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('product_variation_type_id')->index();
            $table->foreign('product_variation_type_id')->references('id')->on('product_variation_types')->cascadeOnDelete();

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();

        });
    }
}
