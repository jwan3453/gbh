<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InternationalCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('international_city', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('country_code');
            $table->string('code',50);
            $table->string('city_name',50);
            $table->string('city_name_en',100);
            $table->integer('status');
            $table->integer('is_hot');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('international_city');
    }
}
