<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
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
        'reservation_time_max',
        'reservation_time_min',
		'geolocation',
        'status'
    ];

    protected $casts = [
	    'notification_email_song' => 'boolean',
	    'notification_email_reservation' => 'boolean',
		'geolocation' => 'boolean',
        'status' => 'boolean'
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y G:ia');
    }

    public function getUpdatedAtAttribute($date)
    {
        if($date) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y G:ia');
        }
    }

    public function labelClass()
    {
        switch($this->status) {
            case 1:
                $class = 'success';
                break;

            case 0:
                $class = 'danger';
                break;

            default:
                $class = 'warning';
        }

        return $class;
    }

    public function textStatus()
    {
        switch($this->status) {
            case 1:
                $text = 'published';
                break;

            case 0:
                $text = 'nopublished';
                break;

            default:
                $text = 'nopublished';
        }

        return $text;
    }

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
