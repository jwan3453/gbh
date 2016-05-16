<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     *---酒店设备表---
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_facility', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facility_name',20);
            $table->string('facility_icon',10);
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_facility');
    }
}
