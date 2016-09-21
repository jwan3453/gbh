<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('section_id');
            $table->integer('type');//1为酒店, 2为房间
            $table->integer('is_cover');//0为否， 1为是
            $table->string('image_key',200);
            $table->string('link',200);
            $table->string('image_desc',200);
            $table->integer('status');
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
        Schema::drop('hotel_image');
    }
}
