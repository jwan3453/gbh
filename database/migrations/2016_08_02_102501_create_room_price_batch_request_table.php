<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateRoomPriceRequestBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_price_batch_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('room_id');
            $table->integer('pay_type');
            $table->date('request_date_from');
            $table->date('request_date_to');
            $table->integer('breakfast');
            $table->integer('is_all_week');
            $table->string('selected_week_day',200);
            $table->integer('is_weekend');
            $table->decimal('week_day_rate',10,2);
            $table->decimal('week_day_comm',10,2);
            $table->decimal('weekend_rate',10,2);
            $table->decimal('weekend_comm',10,2);
            $table->integer('status');//0 是审批中 1 是批准 2 是拒绝
            $table->string('comment',500);
            $table->date('request_date');
            $table->date('approve_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('update_room_price_request');
    }
}
