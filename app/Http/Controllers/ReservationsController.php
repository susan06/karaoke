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
     * Display reservations of user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = 20;
        $admin = false;
        $reservations = $this->reservations->index($perPage, $request->date, Auth::id());

        return view('reservations.index', compact('reservations', 'admin'));
    }

    /**
     * Display reservations of user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminIndex(Request $request)
    {
        $perPage = 20;
        $admin = true;
        $reservations = $this->reservations->index($perPage, $request->date, Auth::id());

        return view('reservations.index', compact('reservations', 'admin'));
    }

    /**
     * Display reservations today.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clientStore()
    {      
        return view('reservations.store');
    }

     /**
     * update status of reservations by admin
     *
     * @return JSON
     */
    public function updateStatus(Request $request)
    {
        $data = ['status' => $request->status];
        $reservation = $this->reservations->update($request->id, $data);
        if ( $reservation ) {
            $response = [
                'success' => true
            ];
        } else {
            $response = [
                'success' => false
            ];  
        }
            
        return response()->json($response);
    }

    /**
     * reservation table by client
     *
     * @param Song $song
     */
    public function reserveByClient(Request $request, NotificationMailer $mailer)
    {
        $date = explode(' / ', $request->date);
        $data = [
                'num_table' => $request->num_table, 
                'user_id' => Auth::id(),
                'date' => date_format(date_create($date[0]), 'Y-m-d'),
                'time' => $date[1]
        ];
        $canCreate = $this->reservations->canAdd($data);
        if ( $canCreate['success'] ) {
            $reservation = $this->reservations->create($data); 
            //$mailer->sendReservation($reservation, Auth::user());
            $response = [
                'success' => true
            ];
        } else {
            $response = [
                'success' => false,
                'message' => $canCreate['message']
            ];  
        }
            
        return response()->json($response);
    }

}
