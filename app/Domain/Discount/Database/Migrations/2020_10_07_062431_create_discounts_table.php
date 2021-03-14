<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('discount_user');
    }

    /**

     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('code', 32)->unique();
            $table->integer('number_of_usage')->default(1);
            $table->float('value')->default(0);
            $table->enum('type', ['amount', 'percentage'])->default('percentage');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('expires_at')->nullable()->format('Y-m-d H:i');
            $table->timestamps();

        });
        Schema::create('discountables', function (Blueprint $table) {
            $table->unsignedBigInteger("discount_id");
            $table->unsignedBigInteger("discountable_id");
            $table->string("discountable_type");
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
        });
        Schema::create('discount_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('discount_id');
            $table->timestamp('used_at')->nullable();
        });
    }
}
