<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchProductTable extends Migration
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

        Schema::dropIfExists('branch_product');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_product', function (Blueprint $table) {
            $table->primary(['branch_id', 'product_id']);
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products', 'id')->onDelete('cascade');
            $table->index(['branch_id', 'product_id']);
        });
    }
}
