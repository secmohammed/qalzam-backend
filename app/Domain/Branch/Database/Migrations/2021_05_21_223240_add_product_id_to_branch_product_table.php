<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductIdToBranchProductTable extends Migration
{

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_product', function (Blueprint $table) {
            $table->dropPrimary(['branch_id', 'product_id','product_variation_id']);
            $table->primary(['branch_id' , 'product_variation_id']);
            $table->dropIndex(['branch_id', 'product_id', 'product_variation_id']);
            $table->index(['branch_id','product_variation_id']);
            $table->dropConstrainedForeignId('product_id');
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_product', function (Blueprint $table) {
            $table->dropPrimary(['branch_id','product_variation_id']);
            $table->primary(['branch_id', 'product_id', 'product_variation_id']);
            $table->foreignId('product_id')->after('branch_id')->constrained('products','id')->onDelete('cascade');
            $table->dropIndex(['branch_id', 'product_variation_id']);
            $table->index(['branch_id', 'product_id','product_variation_id']);
        });
    }

}
