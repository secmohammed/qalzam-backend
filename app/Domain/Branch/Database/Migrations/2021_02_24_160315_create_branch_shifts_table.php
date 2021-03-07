<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchShiftsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_shifts');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_shifts', function (Blueprint $table) {

            $table->id();
            $table->enum('day', ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'friday', 'thursday']);
            $table->time('start_time')->format('H:i');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->time('end_time')->format('H:i');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->index(['branch_id', 'user_id']);
            $table->timestamp('created_at')->useCurrent();

            $table->timestamp('updated_at', 0)->nullable();

        });
    }
}
