<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttibuteTable extends Migration
{
    /**
     * Run the migrations.
     *
     *---属性表---
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attibute', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attibute_name',20);
            $table->string('attibute_icon',10);
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attibute');
    }
}
