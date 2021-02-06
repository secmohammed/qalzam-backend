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
    }
}
