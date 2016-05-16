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
            $table->dateTime('check_time');//入住时间
            $table->dateTime('checkout_time');//离店时间
            $table->string('prompt',500);//酒店提示
            $table->string('catering_arrangements',100);//膳食安排
            $table->integer('is_carry_pets')->default(0);//是否可携带宠物
            
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
