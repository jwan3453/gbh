<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     *----房间设备表-----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_facility', function (Blueprint $table) {
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
        Schema::drop('room_facility');
    }
}
