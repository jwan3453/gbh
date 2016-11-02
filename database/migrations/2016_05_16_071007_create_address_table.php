<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_code')->default(0);
            $table->integer('city_code')->default(0);
            $table->integer('district_code')->default(0);
            $table->string('detail',100);
            $table->string('detail_en',200);
            $table->string('longtitute',15);//经度
            $table->string('latitude',15);//纬度
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
        Schema::drop('address');
    }
}
