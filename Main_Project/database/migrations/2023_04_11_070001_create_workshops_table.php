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
        Schema::create('workshops', function (Blueprint $table) {
            $table->id('workshop_id');
            $table->unsignedBigInteger('workshop_owner_id');
            $table->string('name');
            $table->string('location');
            $table->string('opening_hours');
            $table->string('specialisations');
            $table->integer('phone_no');
            $table->foreign('workshop_owner_id')->references('profile_id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshops');
    }
};
