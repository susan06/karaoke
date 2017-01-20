<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventClient extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_clients';

    public $primaryKey = "id";
    
    public $timestamps = true;

    protected $fillable = [
    	'event_id',
        'user_id'
    ];

    /*
    * Relationships
    *
    */
    public function vote_clients()
    {
        return $this->hasMany(VoteClient::class, 'event_client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
