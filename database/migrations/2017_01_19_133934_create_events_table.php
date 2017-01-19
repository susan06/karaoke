<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('branch_office_id')->nullable()->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('start');  
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('branch_office_id')->references('id')->on('branch_offices')
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
        Schema::drop('events');
    }
}
