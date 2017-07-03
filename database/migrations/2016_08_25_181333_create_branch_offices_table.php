<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('branch_offices', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email_song');
            $table->boolean('notification_email_song')->default(true);  
            $table->string('email_reservations');
            $table->string('reservation_time_min')->nullable();
            $table->string('reservation_time_max')->nullable();
            $table->boolean('notification_email_reservation')->default(true);  
            $table->double('lat');
            $table->double('lng');
            $table->double('radio');
            $table->boolean('geolocation')->default(true);
            $table->boolean('status')->default(true);  
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
         Schema::drop('branch_offices');
    }
}
