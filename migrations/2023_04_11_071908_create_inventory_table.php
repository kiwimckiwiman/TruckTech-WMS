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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id('item_id');
            $table->unsignedBigInteger('workshop_id');
            $table->string('name');
            $table->string('desc');
            $table->unsignedDecimal('price', $precision = 8, $scale = 2);
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('min_stock');
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
        Schema::dropIfExists('inventory');
    }
};
