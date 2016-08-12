<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('room_id');
            $table->integer('room_status');//->comment('房间状态,1:有房,2:房间关闭');
            $table->integer('num_of_blocked_room');
            $table->integer('num_of_solid_room');
            $table->integer('prepaid_room_status');//->comment('房间状态,1:有房,2:房间关闭');
            $table->integer('prepaid_num_of_blocked_room');
            $table->integer('prepaid_num_of_solid_room');
            $table->integer('is_guarantee')->default(1);//->comment('是否需要担保');
            $table->datetime('date');
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
        Schema::drop('room_status');
    }
}
