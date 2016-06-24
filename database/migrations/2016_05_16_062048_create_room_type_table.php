<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     *----房型表-------
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_type', function (Blueprint $table) {
            $table->increments('id');
            $table->float('rack_rate');//门市价
            $table->integer('numb_of_people');//可住人数
            $table->integer('numb_of_children');//可携带儿童人数
            $table->integer('room_num');//房间数量
            $table->float('acreage');//房间面积
            $table->integer('floor');//楼层
            $table->integer('has_window');//是否有窗户
            $table->integer('cable_broadband');// 是否有 有线宽带
            $table->integer('cable_broadband_room');//是否全部房间都有有线宽带
            $table->integer('cable_broadband_free');//是否免费
            $table->integer('wifi');//是否有无线wifi
            $table->integer('wifi_room');//是否所有房间都有无线wifi
            $table->integer('wifi_free');//无线wifi是否免费
            $table->float('broadband_costs');//宽带费用
            $table->integer('bed_type');//床型
            $table->integer('is_extra_bed');//是否可以加床
            $table->integer('extra_bed_costs')->default(0);//加床费用
            $table->integer('somkeless');//是否无烟处理
            $table->string('room_desc');//房型描述

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
        Schema::drop('room_type');
    }
}
