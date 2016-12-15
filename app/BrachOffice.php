<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BrachOffice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'branch_offices';

    public $primaryKey = "id";
    
    public $timestamps = true;

    protected $fillable = [
    	'name',
    	'email_song',
    	'email_reservations',
    	'lat',
    	'lng',
    	'radio',
    	'notification_email_song',
	    'notification_email_reservation',
		'geolocation',
        'status'
    ];

    protected $casts = [
	    'notification_email_song' => 'boolean',
	    'notification_email_reservation' => 'boolean',
		'geolocation' => 'boolean',
        'status' => 'boolean'
    ];

    /*
    * Relationships
    *
    */
    public function user()
    {
        return $this->hasMany(User::class, 'id', 'branch_office_id');
    }

    public function playlist()
    {
        return $this->hasMany(Playlist::class, 'id', 'branch_office_id');
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class, 'id', 'branch_office_id');
    }
}
