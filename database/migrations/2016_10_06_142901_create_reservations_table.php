<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('num_table')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('data_user')->nullable();
            $table->integer('branch_office_id')->unsigned()->nullable();
            $table->integer('coupon_id')->unsigned()->nullable();
            $table->date('date');
            $table->string('time');
            $table->integer('status')->default(0);  
            $table->boolean('arrival')->default(false);
            $table->string('groupfie')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('branch_office_id')->references('id')->on('branch_offices')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('coupon_id')->references('id')->on('coupons')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reservations');
    }
}
