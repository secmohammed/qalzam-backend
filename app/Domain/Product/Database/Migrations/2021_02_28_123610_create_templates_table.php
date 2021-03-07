<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('templates');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->index(['user_id']);
            $table->timestamps();

        });
    }
}
