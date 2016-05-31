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
            $table->integer('province')->default(0);
            $table->integer('city')->default(0);
            $table->integer('district_id')->default(0);
            $table->string('detailed',100);
            $table->string('detailed_english',100);
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
