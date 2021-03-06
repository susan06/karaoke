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
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');   
            $table->string('client_id')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('username')->nullable()->unique();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->integer('branch_office_id')->nullable();
            $table->string('confirmation_token', 60)->nullable();
            $table->string('status', 20);
            $table->rememberToken();
            $table->timestamps();
            $table->engine = 'InnoDB';
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
