<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelUnionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_union', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hotel_name',50)->commont('酒店名');
            $table->string('hotel_address')->commont('酒店地址');
            $table->string('hotel_person')->commont('负责人');
            $table->int('hotel_number',30)->commont('酒店电话');
            $table->int('person_number')->commomt('负责人电话');
            $table->string('person_email')->commont('负责人邮箱');
            $table->text('remarks')->commont('备注信息');
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
        Schema::drop('hotel_union');
    }
}
