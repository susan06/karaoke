<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteClient extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vote_clients';

    public $primaryKey = "id";
    
    public $timestamps = true;

    protected $fillable = [
    	'event_client_id',
        'user_id',
        'event_id'
    ];


    /*
    * Relationships
    *
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event_client()
    {
        return $this->belongsTo(EventClient::class, 'event_client_id');
    }
}
