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
            $table->unsignedInteger('num_table');
            $table->unsignedInteger('user_id');
            $table->date('date');
            $table->string('time');
            $table->boolean('status')->nullable();  
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
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
