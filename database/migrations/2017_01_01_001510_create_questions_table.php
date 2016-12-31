<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('body');
            //问题是谁发起的
            $table->integer('user_id')->unsigned();
            $table->integer('comments_count')->default(0);
            //关注数
            $table->integer('followers_count')->default(1);
            $table->integer('answers_count')->default(0);
            //是否关闭评论
            $table->string('close_comment', 8)->default('F');
            //是否隐藏评论
            $table->string('is_hidden', 8)->default('T');
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
        Schema::dropIfExists('questions');
    }
}
