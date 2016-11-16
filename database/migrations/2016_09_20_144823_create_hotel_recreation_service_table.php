<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelRecreationService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_recreation_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id',100);
            $table->string('name',100); //项目名称
            $table->string('name_en',100);
            $table->integer('num');//数量
            $table->string('description',500);
            $table->string('description_en',500);
            $table->string('image',200);
            $table->string('business_hour',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_recreation_service');
    }
}
