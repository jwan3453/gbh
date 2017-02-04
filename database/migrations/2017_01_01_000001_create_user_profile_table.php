<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelUnionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('user_name',50)->comment('昵称');
            $table->string('phone_no',50)->comment('手机号码');
            $table->string('email',100)->comment('邮箱');
            $table->integer('gender')->comment('性别');
            $table->integer('birth_year')->comment('生日年');
            $table->integer('birth_month')->comment('生日月');
            $table->integer('birth_day')->comment('生日天');
            $table->text('signature')->comment('签名');
            $table->string('avatar')->comment('头像');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotel_union');
    }
}
