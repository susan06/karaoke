<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'songs';

    public $primaryKey = "id";
    
    public $timestamps = true;

    protected $fillable = ['name', 'artist'];
}
