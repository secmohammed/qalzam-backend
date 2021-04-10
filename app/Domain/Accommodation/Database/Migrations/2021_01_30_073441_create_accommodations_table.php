<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodations');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['table', 'room', 'hall']);
            $table->string('code')->unique();
            $table->integer('capacity');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->index(['user_id', 'branch_id']);
            $table->timestamps();

        });
    }
}
