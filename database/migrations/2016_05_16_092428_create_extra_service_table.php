<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     *---附加服务----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_service', function (Blueprint $table) {
            $table->increments('id');
            $table->string('extra_name',100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('extra_service');
    }
}
