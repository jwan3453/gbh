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
            $table->string('order_sn',30);//订单号
            $table->integer('hotel_id');//酒店id
            $table->integer('room_id');//房型id
            $table->integer('user_id');//用户id
            $table->integer('num_of_room');//
            $table->text('guest_list');
            $table->string('contact_phone',50);//联系电话
            $table->string('contact_email',100);//联系邮箱;
            $table->dateTime('check_in_date');//最晚到店时间
            $table->dateTime('check_out_date');//入住时间
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
