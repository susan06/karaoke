<?php

namespace App\Repositories\Reservation;

use DB;
use DateTime;
use Carbon\Carbon;
use App\Reservation;
use App\Repositories\Repository;

class EloquentReservation extends Repository implements ReservationRepository
{

    public function __construct(Reservation $reservation)
    {
        parent::__construct($reservation);
    }

    /**
     *  list Reservation by date
     *
     * @param $perPage
     * @param null $date
     * @param null $user
     */
    public function index($perPage, $date = null, $user = null)
    {
        
        $today = Carbon::today()->toDateString().'%';

        if ($date) {
            $date1 = date_format(date_create($date), 'Y-m-d');
            $query = Reservation::where('date', 'like', $date1.'%')->paginate($perPage);
        } else {
            $query = Reservation::where('date', 'like', $today.'%')->paginate($perPage);
        }

        if ($user) {
            $query->where('user_id', '=', $user);
        }

        if ($date) {
            $query->appends(['date' => $date]);
        }

        return $query;
    }

    /**
     *
     * Can add reservation by superadmin.
     *
     * @param string title
     * @return array
     *
     */
     public function canAdd(array $attributes)
    {
        $reservation = Reservation::where('user_id','=',$attributes['user_id'])
            ->where('num_table', '=', $attributes['num_table'])
            ->where('date', 'like', $attributes['date'])
            ->first();

        $today = Carbon::now();

        $datetime1 = new DateTime(Carbon::now());
        $datetime2 = new DateTime($attributes['date'].' '.$attributes['time']);
        $interval = $datetime1->diff($datetime2);
        $time =$interval->format('%h%');

        $today = Carbon::today()->toDateString();

        if($reservation) {
            return [
                'success' => false, 
                'message' => 'Ya tiene una reserva con la mesa: '.$attributes['num_table'].' para el día '.date_format(date_create($attributes['date']), 'd-m-Y')
            ];
        } 
        if ($attributes['date'] == $today && $time <= 2) {
            return [
                'success' => false, 
                'message' => 'Solo puede reservar la mesa dos horas antes de la estipulada'
            ];
        }

        return ['success' => true];
    }

}