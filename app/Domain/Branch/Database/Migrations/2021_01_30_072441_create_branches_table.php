<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_product', function (Blueprint $table) {
            $table->dropForeign(['product_id', 'branch_id']);
        });

        Schema::dropIfExists('branches');
        Schema::dropIfExists('branch_product');

    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {

            $table->id();
            $table->string('name')->unique();
            $table->foreignId('location_id')->constrained();
            $table->float('latitude');
            $table->float('longitude');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('creator_id')->constrained('users', 'id');
            $table->index(['creator_id', 'location_id', 'user_id']);
            $table->timestamps();

        });
        Schema::create('branch_product', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->primary(['branch_id', 'product_id']);
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });
    }
}
