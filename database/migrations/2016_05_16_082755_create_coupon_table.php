<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     *---优惠券码表---
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_sn',20);
            $table->integer('coupon_amount');
            $table->dateTime('add_time');
            $table->integer('is_use');
            $table->dateTime('use_time');
            $table->integer('user_id')->default(0);
            $table->integer('order_id')->default(0);
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
        Schema::drop('coupon');
    }
}
