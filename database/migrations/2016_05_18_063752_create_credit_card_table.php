<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     *---信用卡信息-----
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_card', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('credit_type');//--国内银联卡/国内各类银行卡明细/国外信用卡明细
            $table->string('credit_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('credit_card');
    }
}
