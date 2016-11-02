<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     *---酒店设备设置---
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_facility', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->string('contact_json',2000);
            $table->string('payment_json',2000);
            $table->string('facilities_checkbox',2000);
            $table->timestamps();
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
