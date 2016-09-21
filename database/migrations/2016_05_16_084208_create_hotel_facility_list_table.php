<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelFacilityListTable extends Migration
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
        Schema::create('hotel_facility_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category');
            $table->string('name',100);
            $table->string('name_eg',100);
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_facility_list');
    }
}
