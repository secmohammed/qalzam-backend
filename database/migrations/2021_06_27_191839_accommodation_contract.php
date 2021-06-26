<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccommodationContract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_contract', function (Blueprint $table) {
            $table->primary(['accommodation_id', 'contract_id']);
            $table->foreignId('accommodation_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_id')->constrained()->onDelete('cascade');
            $table->index(['accommodation_id', 'contract_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accommodation_contract', function (Blueprint $table) {
            $table->dropForeign(['accommodation_id', 'contract_id']);
        });

        Schema::dropIfExists('accommodation_contract');
    }
}
