<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('uid')->comment('用户id');
            $table->string('name', 20)->comment('昵称');
            $table->string('email',50)->comment('电子邮箱');
            $table->tinyInteger('age',false,true)->comment('年龄');
            $table->char('city',10)->comment('城市');
            $table->string('introduction', 100)->comment('介绍');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `mi_users` comment'用户表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
