<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HotelCateringService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_catering_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id',100);
            $table->string('name',100); //项目名称
            $table->string('name_en',100);
            $table->float('size');//面积
            $table->integer('num_of_table');
            $table->string('description',500);//描述
            $table->string('description_en',500);
            $table->string('image',200);//图片链接
            $table->string('business_hour',100);//营业时间
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_catering_service');
    }
}
