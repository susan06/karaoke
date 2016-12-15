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

    protected $fillable = ['song_id', 'user_id', 'branch_office_id', 'play_status'];

    protected $casts = [
        'play_status' => 'boolean'
    ];

    /*
    * Relationships
    *
    */
    public function song()
    {
        return $this->hasOne(Song::class, 'id', 'song_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function branchoffice()
    {
        return $this->belongsTo(BrachOffice::class, 'branch_office_id');
    }
}
