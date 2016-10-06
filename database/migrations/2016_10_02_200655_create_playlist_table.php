<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('song_id');
            $table->unsignedInteger('user_id');
            $table->boolean('play_status')->default(false);  
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('song_id')->references('id')->on('songs')
                ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::drop('playlists');
    }
}
