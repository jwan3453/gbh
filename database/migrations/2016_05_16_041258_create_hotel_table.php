<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelTable extends Migration
{
    /**
     * Run the migrations.
     *
     *------酒店表----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hotel_name',100);
            $table->integer('address_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('style_id')->default(0);
            $table->integer('brand_id')->default(0);
            $table->integer('star_level')->default(0);
            $table->integer('to_admin_user')->default(0);
            $table->integer('status')->default(0);
            $table->string('description',1000);
            $table->integer('policy_id')->default(0);
            $table->string('tag',200);

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
        Schema::drop('hotel');
    }
}
