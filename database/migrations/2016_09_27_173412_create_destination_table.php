<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestination extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city_code',50);
            $table->integer('num_of_hotel');
            $table->string('description',500);
            $table->string('description_en',500);
            $table->string('cover_image',200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('destination');
    }
}
