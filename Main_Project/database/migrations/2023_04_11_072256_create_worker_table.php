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
        Schema::create('worker', function (Blueprint $table) {
            $table->id('worker_id');
            $table->unsignedBigInteger('workshop_id');
            $table->boolean('has_inventory_access');
            $table->boolean('has_job_access');
            $table->foreign('worker_id')->references('user_id')->on('users');
            $table->foreign('workshop_id')->references('workshop_id')->on('workshops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worker');
    }
};
