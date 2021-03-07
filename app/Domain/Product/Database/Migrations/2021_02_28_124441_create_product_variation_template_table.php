<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariationTemplateTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variation_template');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variation_template', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->index();
            $table->unsignedBigInteger('product_variation_id')->index();
            $table->unsignedBigInteger('quantity')->default(1);
            $table->integer('price');
            $table->timestamps();
            $table->primary(['template_id', 'product_variation_id'], 'product_template_index');
            $table->foreign('template_id')->references('id')->on('templates')->cascadeOnDelete();
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->cascadeOnDelete();
        });
    }
}
