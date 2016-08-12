<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_price', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('room_id');
            $table->decimal('rate',10,2);
            $table->decimal('prepaid_rate',10,2);
            $table->decimal('commission',10,2);
            $table->decimal('prepaid_commission',10,2);
            $table->integer('num_of_breakfast');
            $table->integer('prepaid_num_of_breakfast');
            $table->datetime('date');
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
        Schema::drop('room_price');
    }
}
