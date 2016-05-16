<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     *---用户等级表----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_level', function (Blueprint $table) {
            $table->increments('id');
            $table->string('level_name',50);
            $table->string('level_condition',50);
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_level');
    }
}
