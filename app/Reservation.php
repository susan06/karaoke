<?php

namespace App;

use Carbon\Carbon;
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

    protected $fillable = [
        'num_table', 
        'user_id', 
        'data_user',
        'date', 
        'time', 
        'status', 
        'arrival', 
        'branch_office_id', 
        'coupon_id',
        'groupfie'
    ];

    protected $casts = [
        'status' => 'int',
        'arrival' => 'boolean'
    ];

    public function num_reservation() 
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('m').$this->id.Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y');
    }

    public function nextStatus()
    {
        switch($this->status) {
            case 0:
                $class = 1;
                break;

            case 1:
                $class = 2;
                break;

            case 2:
                $class = 1;
                break;

            case 3:
                $class = 0;
                break;
        }

        return $class;
    }

    public function classBtnStatus()
    {
        switch($this->status) {
            case 0:
                $class = 'btn-success';
                break;

            case 1:
                $class = 'btn-warning';
                break;

            case 2:
                $class = 'btn-success';
                break;
        }

        return $class;
    }

    public function textBtnStatus()
    {
        switch($this->status) {
            case 0:
                $class = 'Confirmar Reserva';
                break;

            case 1:
                $class = 'Rechazar Reserva';
                break;

            case 2:
                $class = 'Aprobar Reserva';
                break;
        }

        return $class;
    }

    public function data_user() {
        $data = null;
        if($this->user_id) {
            $data = null;
            $data = 'nombre: '.$this->user->first_name . ' ' . $this->user->last_name .'<br>';
            $data = $data.'email: '.$this->user->email.'<br>';
            $data = $data.'Télefono: '.$this->user->phone;
        }

        if($this->data_user) {
            $data = null;
            $user = json_decode($this->data_user);
            $data = 'nombre: '.$user->name.'<br>';
            $data = $data.'email: '.$user->email.'<br>';
            $data = $data.'Télefono: '.$user->phone.'<br>';
            $data = $data.'Usuario no registrado';
        }

        return $data;
    }

    public function name_user() {
        $data = null;
        if($this->user_id) {
            $data = null;
            $data = $this->user->first_name . ' ' . $this->user->last_name;
        }

        if($this->data_user) {
            $data = null;
            $user = json_decode($this->data_user);
            $data = $user->name;
        }

        return $data;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function branchoffice()
    {
        return $this->belongsTo(BranchOffice::class, 'branch_office_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
