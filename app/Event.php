<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    public $primaryKey = "id";
    
    public $timestamps = true;

    protected $fillable = [
    	'branch_office_id',
        'name',
        'description',
        'status',
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y G:ia');
    }

    public function labelStatus()
    {
        switch($this->status) {
            case 'start':
                $class = '<span class="label label-success">'.trans("app.{$this->status}").'</span>';
                break;

            case 'finish':
                $class = '<span class="label label-danger">'.trans("app.{$this->status}").'</span>';
                break;

            default:
                $class = '';
        }

        return $class;
    }

    /*
    * Relationships
    *
    */
    public function event_clients()
    {
        return $this->hasMany(EventClient::class, 'id', 'event_id');
    }
}
