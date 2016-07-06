<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('category');
            $table->string('title');
            $table->string('subtitle');
            $table->string('author');
            $table->text('brief');
            $table->text('content_raw');
            $table->text('content_html');
            $table->string('cover_image');
            $table->string('wechat_url',500);
            $table->string('meta_description');
            $table->boolean('is_draft');
            $table->integer('view_count')->default(0);
            $table->integer('praise')->default(0);
            $table->timestamp('published_at')->index();
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
        Schema::drop('article');
    }
}
