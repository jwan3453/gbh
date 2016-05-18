<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     *----交通线路表----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transport_line', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('transport_category');//所属类别
            $table->integer('transport_city');//所属城市
            $table->string('transport_address',100);//地点信息
            $table->float('distance');//距离

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
        Schema::drop('transport_line');
    }
}
