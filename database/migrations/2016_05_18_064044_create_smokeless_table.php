<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmokelessTable extends Migration
{
    /**
     * Run the migrations.
     *
     *----无烟-----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smokeless', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('smokeless');
    }
}
