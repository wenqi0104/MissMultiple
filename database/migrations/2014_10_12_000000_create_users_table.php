<?php

use Illuminate\Support\Facades\Schema;
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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); 

            /* 年龄 unsigned 指的是只能插入正数*/
            $table->integer('age')->unsigned()->default(13);
            /* 性别 */
            $table->string('gender')->nullable()->default('Male');
            /* 用户类型 */
            $table->string('type')->default('Student');
            $table->string('avatar')->nullable()->default('noavatar.png');
            $table->string('status')->default('Unblocked');

            


        });
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
