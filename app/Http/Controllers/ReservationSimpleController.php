<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\BranchOffice\BranchOfficeRepository;
use App\Repositories\User\UserRepository;
use App\Mailers\NotificationMailer;

class ReservationSimpleController extends Controller
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
     * @var UserRepository
     */
    private $users;

    public function __construct(
    	ReservationRepository $reservations, 
    	BranchOfficeRepository $branch_offices,
    	UserRepository $users
    ){
        $this->reservations = $reservations;
        $this->branch_offices = $branch_offices;
        $this->users = $users;
    }

    /**
     * Index 
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $branch_offices = $this->branch_offices->all();
        $branch_office = $branch_offices->first();

        if ($request->branch_office_id) {
            $branch_office = $this->branch_offices->find($request->branch_office_id);
            session()->put('branch_office', $branch_office); 
        }

        if ( count($branch_offices) > 1) {
            session()->put('branch_offices', $this->branch_offices->lists_actives()); 
        } 

        if(!session('branch_office') && !$request->branch_office_id) {
            session()->put('branch_office', $branch_office); 
        } 

        return view('reservations.store-simple', compact('branch_offices'));
    }

        /**
     * reservation table by client
     *
     * @param Song $song
     */
    public function reserveByClient(Request $request, NotificationMailer $mailer)
    {
        $user_id = $request->user_id;
        $data = [
          'num_table' => $request->num_table, 
          'user_id' => $user_id,
          'branch_office_id' => session('branch_office')->id,
          'date' => date_format(date_create($request->date), 'Y-m-d'),
          'time' => $request->time
        ];
        $canCreate = $this->reservations->canAdd($data);
        if ( $canCreate['success'] ) {
            $reservation = $this->reservations->create($data); 
            $message_alert = false;
            if(session('branch_office')->notification_email_reservation == 1) {
              try {
                $user = $this->users->find($user_id);
                $mailer->sendReservation($reservation, $user);
              } 
              catch(\Swift_TransportException $e){
			        $message_alert = 'Se ha guardado su reserva, pero falló la conexión para el envio de la notificación a la administración.';
			  }
    		  catch (\Exception $e) {
                $message_alert = 'Se ha guardado su reserva, pero falló el envio de la notificación a la administración.';
              }
            }
            $response = [
                'success' => true,
                'message_alert' => $message_alert
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
