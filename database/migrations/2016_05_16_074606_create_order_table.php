<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_sn',30);
            $table->integer('hotel_id');
            $table->integer('room_id');
            $table->integer('user_id');
            $table->integer('room_num');
            $table->integer('order_personnel_id');
            $table->string('contact_phone',15);
            $table->dateTime('arrive_time');//最晚到店时间
            $table->dateTime('check_time');//入住时间
            $table->dateTime('checkout_time');//退房时间
            $table->integer('total_amount');
            $table->integer('pay_status');
            $table->integer('payment_id');
            $table->string('coupon_code',20);
            $table->integer('is_guarantee');//是否缴纳保证金
            $table->integer('order_status');
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
        Schema::drop('order');
    }
}
