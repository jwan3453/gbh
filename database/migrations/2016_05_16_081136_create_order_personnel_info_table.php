<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPersonnelInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     *----订单入住用户---
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_personnel_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('room_id');
            $table->string('personnel_name',20);
            $table->string('personnel_card',20);
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
        Schema::drop('order_personnel_info');
    }
}
