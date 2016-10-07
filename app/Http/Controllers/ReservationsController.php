<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Reservation;
use App\Http\Requests;
use App\Mailers\NotificationMailer;
use App\Repositories\Reservation\ReservationRepository;

class ReservationsController extends Controller
{

    /**
     * @var ReservationRepository
     */
    private $reservations;

    /**
     * ReservationsController constructor.
     * @param ReservationRepository $reservations
     */
    public function __construct(ReservationRepository $reservations)
    {
        $this->middleware('auth');
        $this->reservations = $reservations;
    }

     /**
     * Display reservations today.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clientIndex()
    {
        return view('reservations.clientIndex');
    }

     /**
     * update status of reservations by admin
     *
     * @return JSON
     */
    public function updateStatus()
    {
        //
    }

    /**
     * reservation table by client
     *
     * @param Song $song
     */
    public function reserveByClient(Request $request, NotificationMailer $mailer)
    {
        try {
            $date = explode(' / ', $request->date);
            $reservation = $this->reservations->create([
                'num_table' => $request->num_table, 
                'user_id' => Auth::id(),
                'date' => date_format(date_create($date[0]), 'Y-m-d'),
                'time' => $date[1]
            ]); 
            $mailer->sendReservation($reservation, Auth::user());
            $response = [
                'success' => true
            ];
        } catch (Exception $e){
            $response = [
                'success' => false
            ];
        }
            
        return response()->json($response);
        
    }

}
