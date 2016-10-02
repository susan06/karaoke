<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'playlists';

    public $primaryKey = "id";
    
    public $timestamps = true;

    protected $fillable = ['song_id', 'user_id', 'play_status'];

    /*
    * Relationships
    *
    */
    public function song()
    {
        return $this->hasOne(Song::class, 'id', 'song_id');
    }
}