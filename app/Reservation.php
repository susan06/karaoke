<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservations';

    public $primaryKey = "id";
    
    public $timestamps = true;

    protected $fillable = ['num_table', 'user_id', 'date', 'time', 'status'];

    protected $casts = [
        'status' => 'boolean'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}