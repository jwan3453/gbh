<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBedTable extends Migration
{
    /**
     * Run the migrations.
     *
     *---床型表----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->integer('room_id');
            $table->string('type_name',50);
            $table->float('length');
            $table->float('width');
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
        Schema::drop('bed');
    }
}
