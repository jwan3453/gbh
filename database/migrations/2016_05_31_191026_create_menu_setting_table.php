<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('menu_name',20);
            $table->string('menu_name_eg',20);
            $table->integer('menu_level');
            $table->integer('menu_status');
            $table->string('menu_chaining',100);
            $table->string('icon_img_1',100);
            $table->string('icon_img_2',100);
            $table->integer('parent_id');
            $table->string('menu_description',200);
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
        Schema::drop('menu_setting');
    }
}
