<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     *----城市表----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',50);
            $table->string('city_name',50);
            $table->string('city_name_en',100);
            $table->string('province_code',50);
            $table->string('initial',1);
            $table->integer('status');
            $table->integer('parent_id');
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
        Schema::drop('city');
    }
}
