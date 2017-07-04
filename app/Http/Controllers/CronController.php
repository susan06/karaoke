<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Repositories\Reservation\ReservationRepository;
use App\Mailers\NotificationMailer;

class CronController extends Controller
{
     /**
     * @var ReservationRepository
     */
    private $reservations;

    public function __construct(
        ReservationRepository $reservations
    ){
        $this->reservations = $reservations;
    }

    public function reminder(NotificationMailer $mailer)
    {
        $reservations = $this->reservations->where('date', date('Y-m-d'))
            ->where('status', 1)->where('arrival', 0)->get();

        foreach ($reservations as $key => $reservation) {
            $time = Carbon::parse($reservation->time)->format('H'); 
            if($time == date('H')) {
        	  $mailer->sendReminderReservation($reservation);
            }
        }
    }

}
