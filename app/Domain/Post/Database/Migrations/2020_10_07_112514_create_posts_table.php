<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->enum('type', ['featured', 'normal'])->default('normal');
            $table->enum('status', ['approved', 'disapproved'])->default('disapproved');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
}
