<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelTable extends Migration
{
    /**
     * Run the migrations.
     *
     *------酒店表----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',50);
            $table->string('name',100);
            $table->string('name_en',100);
            $table->integer('address_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('style_id')->default(0);
            $table->integer('brand_id')->default(0);
            $table->integer('star_level')->default(0);
            $table->integer('has_stars_mark');//是否挂牌星级
            $table->integer('admin_user')->default(0);
            $table->integer('status')->default(0);
            $table->string('description',1000);
            $table->string('description_en',1000);
            $table->integer('policy_id')->default(0);
            $table->string('tag',200);
            $table->integer('postcode');
            $table->string('phone',20);//酒店总机号码
            $table->string('fax',20);//商务中心传真
            $table->string('website',50);//网址
            $table->integer('total_rooms');//酒店房间总数
            $table->string('surrounding_environment',250);//周边环境
            $table->string('hotel_brief');
            $table->string('hotel_brief_en');
            $table->string('hotel_features',300);//酒店特色
            $table->string('hotel_features_en',300);//酒店特色
            $table->string('hotel_features_eng',300);

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
        Schema::drop('hotel');
    }
}
