<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelPolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     *----酒店政策-----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_policy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->string('checkin_time',200);//入住时间
            $table->string('checkout_time',200);//离店时间
            $table->string('prepaid_deposit',500);//酒店提示
            $table->string('prepaid_deposit_en',500);//酒店提示
            $table->string('airport_transfer',200);//接送机
            $table->string('airport_transfer_en',500);//接送机
            $table->string('pay_policy',200);//支付政策
            $table->string('pay_policy_en',500);//支付政策
            $table->string('pet_policy',200);//支付政策
            $table->string('pet_policy_en',500);//支付政策
            $table->string('catering_arrangements',500);//膳食安排
            $table->string('catering_arrangements_en',500);//膳食安排
            $table->string('service_fee_policy',500);//服务费
            $table->string('service_fee_policy_en',500);//服务费
            $table->string('other_policy',500);
            $table->string('other_policy_en',500);
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
        Schema::drop('hotel_policy');
    }
}
