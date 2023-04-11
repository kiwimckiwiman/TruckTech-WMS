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
        Schema::create('job', function (Blueprint $table) {
            $table->id('job_id');
            $table->unsignedBigInteger('workshop_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('worker_id');
            $table->string('vehicle_plate');
            $table->string('vehicle_make');
            $table->string('desc');
            $table->timestamp('start_time');
            $table->timestamp('finish_time')->nullable();
            $table->string('comment');
            $table->string('invoice_link');
            $table->string('feedback');
            $table->foreign('workshop_id')->references('workshop_id')->on('workshops');
            $table->foreign('customer_id')->references('profile_id')->on('profiles');
            $table->foreign('worker_id')->references('worker_id')->on('worker');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job');
    }
};
