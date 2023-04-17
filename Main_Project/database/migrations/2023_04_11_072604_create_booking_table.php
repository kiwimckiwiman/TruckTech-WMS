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
        Schema::create('booking', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('workshop_id')->nullable()->default(0);
            $table->string('vehicle_plate');
            $table->string('vehicle_make');
            $table->string('desc');
            $table->timestamp('time_created')->useCurrent();
            $table->enum('accepted_status', ['pending', 'accepted', 'rejected']);
            $table->timestamp('accepted_time')->nullable();
            $table->foreign('customer_id')->references('user_id')->on('users');
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
        Schema::dropIfExists('booking');
    }
};
