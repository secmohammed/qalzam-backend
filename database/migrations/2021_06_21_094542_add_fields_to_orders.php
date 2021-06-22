<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('type',['delivery','pickup'])->default('delivery');
            $table->foreignId('delivery_id')->nullable()->constrained('users','id')->onDelete("cascade");
            $table->dateTime('assign_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['assign_date','type']);
            $table->dropForeign('delivery_id');
        });
    }
}
