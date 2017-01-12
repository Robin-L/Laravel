<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');   // 创建了一个integer类型的自增id
            $table->string('name');     // 创建name字段
            $table->string('email')->unique();  // 值为唯一值
            $table->string('password', 60);     // 最大长度为60
            $table->rememberToken();    // 为用户创建一个remember_token字段
            $table->timestamps();       // 创建created_at 和 updated_at字段
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
