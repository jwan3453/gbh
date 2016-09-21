<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id');
            $table->string('telephone',50);
            $table->string('mobile',50);
            $table->string('position',50);
            $table->string('fax',50);
            $table->string('email',60);
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
        Schema::drop('hotel_contact');
    }
}
