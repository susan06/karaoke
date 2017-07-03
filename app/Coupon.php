<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'coupons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'validity', 'percentage', 'status', 'created_by'
    ];

    /**
     * Functions
     *
     */
    public function codeDecrypt()
    {
        return decrypt($this->code);
    }

    public function validity_class()
    {
        switch($this->status) {
            case 'Valid':
                $class = '';
                break;

            case 'noValid':
                $class = 'overline';
                break;

            default:
                $class = '';
        }

        return $class;
    }

    public function labelClass()
    {
        switch($this->status) {
            case 'Valid':
                $class = 'success';
                break;

            case 'noValid':
                $class = 'danger';
                break;

            default:
                $class = 'success';
        }

        return $class;
    }

    public function getValidityAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    }

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

    public function isValid()
    {
        return $this->status == 'Valid';
    }

    public function isNoValid()
    {
        return $this->status == 'noValid';
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = encrypt($value);
    }

    public function setValidityAttribute($value)
    {
        $this->attributes['validity'] = date_format(date_create($value), 'Y-m-d');
    }
    
    /**
     * Relationships
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reservations()
    {
        return $this->hasMany(Reservations::class, 'coupon_id');
    }

}
