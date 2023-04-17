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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 20)->unique();
            $table->string('password');
            $table->string('email', 50)->unique();
            $table->string('name', 50);
            $table->date('DOB');
            $table->string('company', 50);
            $table->unsignedInteger('phone_no');
            $table->enum('type', ['c', 'w', 'a', 's']);
        });

        DB::table('users')->insert(
        array(
            'username' => 'admin',
            'password' => '$2y$10$WHZWjSrU2pfsjrCouoBJa.UEVDtz9PEHN0j4OGOSIH.dUM6SopxLW',
            'email' => 'admin@email.com',
            'type' => 's',
            'name' => 'admin',
            'DOB' => date("Y/m/d"),
            'company' => 'SafeTruck',
            'phone_no' => 011111111111
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
