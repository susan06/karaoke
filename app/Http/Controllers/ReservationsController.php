<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Settings;
use Auth;
use App\Reservation;
use App\Http\Requests;
use App\Mailers\NotificationMailer;
use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\BranchOffice\BranchOfficeRepository;

class ReservationsController extends Controller
{

    /**
     * @var ReservationRepository
     */
    private $reservations;

    /**
     * @var BranchOfficeRepository
     */
    private $branch_offices;

    /**
     * ReservationsController constructor.
     * @param ReservationRepository $reservations
     */
    public function __construct(ReservationRepository $reservations, BranchOfficeRepository $branch_offices)
    {
        $this->middleware('auth');
        $this->reservations = $reservations;
        $this->branch_offices = $branch_offices;
    }

     /**
     * Display reservations of user.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $branch_offices = $this->branch_offices->all();

        if ( count($branch_offices) > 1 && !session('branch_offices')) {
            session()->put('branch_offices', $this->branch_offices->lists_actives()); 
        } 

        if ($request->branch_office_id) {
            $branch_office = $this->branch_offices->find($request->branch_office_id);
            session()->put('branch_office', $branch_office); 
        }
        
        $perPage = 20;
        $admin = false;
        $reservations = $this->reservations->index($perPage, $request->date, Auth::id(), $admin);

        return view('reservations.index', compact('reservations', 'admin', 'all'));
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
        $reservations = $this->reservations->index($perPage, $request->date, null, $admin, $request->branch_office_id);

        return view('reservations.index', compact('reservations', 'admin', 'all'));
    }

    /**
     * Display reservations today.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clientStore(Request $request)
    {      
        $branch_offices = $this->branch_offices->all();

        if ( count($branch_offices) > 1 && !session('branch_offices')) {
            session()->put('branch_offices', $this->branch_offices->lists_actives()); 
        } 

        if ($request->branch_office_id) {
            $branch_office = $this->branch_offices->find($request->branch_office_id);
            session()->put('branch_office', $branch_office); 
        }

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
        $data = [
                'num_table' => $request->num_table, 
                'user_id' => Auth::id(),
                'branch_office_id' => session('branch_office')->id,
                'date' => date_format(date_create($request->date), 'Y-m-d'),
                'time' => $request->time
        ];
        $canCreate = $this->reservations->canAdd($data);
        if ( $canCreate['success'] ) {
            $reservation = $this->reservations->create($data); 
            if(Settings::get('notification_email_reservation') == 1) {
                $mailer->sendReservation($reservation, Auth::user());
            }
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

    /**
     * Removes the reservations from database.
     *
     * @param Request $request
     * @return $this
     */
    public function delete(Request $request)
    {
        $destroy = $this->reservations->delete($request->id);

        return response()->json(['success'=> true]);
    }

}
