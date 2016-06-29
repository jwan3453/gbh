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
            $table->string('room_bed_category',50);
            $table->integer('bed_type_id');
            $table->float('length');
            $table->float('width');
            $table->integer('num_of_beds');
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
