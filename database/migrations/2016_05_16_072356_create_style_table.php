<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     *----酒店风格表----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('style', function (Blueprint $table) {
            $table->increments('id');
            $table->string('style_name',20);
            $table->integer('style_level')->default(0);
            $table->integer('parent_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('style');
    }
}
