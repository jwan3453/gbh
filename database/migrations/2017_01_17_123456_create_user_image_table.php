<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('type');//1.用户头像,2 评论头像
            $table->integer('is_cover');
            $table->string('image_key',200);
            $table->string('link',200);
            $table->string('desc',200);
            $table->string('coords',200);
            $table->integer('status');
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
        Schema::drop('user_image');
    }
}
