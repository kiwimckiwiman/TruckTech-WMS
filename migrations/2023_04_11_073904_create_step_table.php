<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step', function (Blueprint $table) {
            $table->bigIncrements('step_id');
            $table->unsignedBigInteger('job_id');
            $table->timestamp('time_created');
            $table->unsignedBigInteger('worker_id');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedDecimal('worker_fee', $precision = 8, $scale = 2);
            $table->foreign('worker_id')->references('worker_id')->on('worker');
            $table->foreign('item_id')->references('item_id')->on('inventory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step');
    }
};
