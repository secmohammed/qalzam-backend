<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindablesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remindables');
    }

    /**

     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remindables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('token')->unique()->nullable();
            $table->enum('type', ['activation', 'reminder']);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->dateTime('completed_at')->format('Y-m-d H:i')->nullable();
            $table->dateTime('expires_at')->format('Y-m-d H:i');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();

        });
    }
}
