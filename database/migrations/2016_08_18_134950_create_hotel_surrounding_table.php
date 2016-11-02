<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelSurroundingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_surrounding', function (Blueprint $table) {
            $table->increments('id');
            $table->increments('hotel_id');
            $table->string('name',100);
            $table->string('name_en',100);
            $table->integer('distance');
            $table->integer('by_taxi');
            $table->integer('by_walk');
            $table->string('by_bus',200);
            $table->string('by_sub',200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_surrounding');
    }
}
