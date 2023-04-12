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
         Schema::create('profiles', function (Blueprint $table) {
             $table->id('profile_id');
             $table->string('name', 50);
             $table->date('DOB');
             $table->string('company', 50);
             $table->unsignedInteger('phone_no');
             $table->foreign('profile_id')->references('user_id')->on('users');
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists('profiles');
     }
};
