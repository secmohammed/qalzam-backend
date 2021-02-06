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
        Schema::dropIfExists('branch_product');

        Schema::dropIfExists('branches');

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
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('delivery_fee');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('creator_id')->constrained('users', 'id')->onDelete('cascade');
            $table->index(['location_id', 'user_id', 'creator_id']);
            $table->timestamps();

        });
        Schema::create('branch_product', function (Blueprint $table) {
            $table->primary(['branch_id', 'product_id']);
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products', 'id')->onDelete('cascade');
            $table->index(['branch_id', 'product_id']);
        });
        Schema::create('delivery_order', function (Blueprint $table) {
            $table->primary(['user_id', 'order_id']);
            $table->foreignId('order_id')->constrained('orders', 'id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->index(['order_id', 'user_id']);

        });
    }
}
