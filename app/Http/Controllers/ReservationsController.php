<?php

namespace App\Http\Controllers;

use Settings;
use Auth;
use DateTime;
use Storage;
use Validator;
use Exception;
use App\Reservation;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Mailers\NotificationMailer;
use App\Support\Enum\UserStatus;
use App\Repositories\User\UserRepository;
use App\Repositories\Reservation\ReservationRepository;
use App\Repositories\BranchOffice\BranchOfficeRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Coupon\CouponRepository;

class ReservationsController extends Controller
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var ReservationRepository
     */
    private $reservations;

    /**
     * @var BranchOfficeRepository
     */
    private $branch_offices;

    /**
     * @var CouponRepository
     */
    private $coupons;

    /**
     * ReservationsController constructor.
     * @param ReservationRepository $reservations
     */
    public function __construct(
        ReservationRepository $reservations, 
        BranchOfficeRepository $branch_offices, 
        UserRepository $users,
        RoleRepository $roles,
        CouponRepository $coupons
    ){
        $this->middleware('auth');
        $this->reservations = $reservations;
        $this->branch_offices = $branch_offices;
        $this->users = $users;
        $this->roles = $roles;
        $this->coupons = $coupons;
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

        if ( $request->ajax() ) {        
            return response()->json([
                'success' => true,
                'view' => view('reservations.list', compact('reservations', 'admin', 'all'))->render(),
            ]);       
        }

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
     * update status of reservations by admin and client when status CANCELED
     *
     * @return JSON
     */
    public function updateStatus(Request $request, NotificationMailer $mailer)
    {
        $data = ['status' => $request->status];
        $reservation = $this->reservations->update($request->id, $data);
        if ( $reservation ) {
            if(Auth::user()->hasRole('admin') && $request->status == 1 || $request->status == 2) {
              $mailer->sendStatusReservation($reservation);
            }
            if(Auth::user()->hasRole('user') && $request->status == 3 && $reservation->notification_email_reservation == 1) {
              $mailer->sendStatusReservationAdmin($reservation, Auth::user());
            }
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
     * update arrival of reservations by client
     *
     * @return JSON
     */
    public function updateArrival(Request $request, NotificationMailer $mailer)
    {
        $data = ['arrival' => true];
        $reservation = $this->reservations->update($request->id, $data);
        if ( $reservation ) {
            if(Auth::user()->hasRole('user') && $reservation->notification_email_reservation == 1) {
                $mailer->sendStatusReservationAdmin($reservation, Auth::user());
            }
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
            if(session('branch_office')->notification_email_reservation == 1) {
              $mailer->sendReservation($reservation, Auth::user());
            }
            $response = [
                'success' => true,
                'correo' => session('branch_office')->email_reservations
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
     * reservation table by admin
     *
     * @param Song $song
     */
    public function reserveByAdmin(Request $request, NotificationMailer $mailer)
    {
        $user = $this->users->findByEmail($request->email_client);
        if (! $user) {
            $user = $this->users->create([
                'email' => $request->email_client,
                'client_id' => $this->getClientNumber(),
                'password' => str_random(10),
                'first_name' => $request->name_client,
                'last_name' => $request->last_client,
                'phone' => $request->phone_client,
                'status' => UserStatus::ACTIVE,
            ]);

            $this->users->updateSocialNetworks($user->id, ['facebook' => '']);

            $role = $this->roles->findByName('user');
            $user->attachRole($role);
        } else {
            $this->users->update($user->id, [
                'client_id' => ($user->client_id) ? $user->client_id : $this->getClientNumber(),
                'phone' => $request->phone_client,
            ]);
        }
        $data = [
                'num_table' => $request->num_table, 
                'user_id' => $user->id,
                'branch_office_id' => $request->branch_office_id,
                'date' => date_format(date_create($request->date), 'Y-m-d'),
                'time' => $request->time
        ];
        $canCreate = $this->reservations->canAdd($data);
        if ( $canCreate['success'] ) {
            $reservation = $this->reservations->create($data); 
            if(session('branch_office')->notification_email_reservation == 1) {
                $mailer->sendReservation($reservation, $user);
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


    public function getClientNumber(){
     do{
        $rand = $this->generateRandomString(4);
      }while(! empty($this->users->where('client_id',$rand)->first()) );

       return $rand;
    }

    public function generateRandomString($length) {
        $characters = '123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Store groupfie
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadGroupfie(Request $request)
    {
      $rules =  ['groupfie' => 'required|image'];
      $validator = Validator::make($request->all(), $rules);
      if ( $validator->passes() ) {
          $file = $request->groupfie;
          $date = new DateTime();
          $file_name = $date->getTimestamp().'.'.$file->extension();
          
          if($file){
              if ($file->isValid()) {
                  Storage::disk('groupfie')->put($file_name, \File::get($file));
              }else{

                  return response()->json([
                      'success' => false,
                      'message' => 'Ocurrió un error al subir la foto, intente de nuevo'
                  ]);
              }
          }
          $data = [
              'code' => str_random(6),
              'percentage' => 15,
              'validity' => date('Y-m-d'),
              'status' => 'Valid',
              'created_by' => Auth::id(),
          ];
          $coupon = $this->coupons->create($data);
          $reservation = $this->reservations->update($request->id,  [
            'groupfie' => $file_name,
            'coupon_id' => $coupon->id
          ]);

          return response()->json([
              'success' => true,
              'message' => '<p>GROUPFIE guardada con éxito, se le ha enviado a su 
                  correo la validación de un cupón, valido solo por hoy, puedes 
                  reclamar un descuento del 15 % por caja</p>
                  <br><p>Código:'.$coupon->codeDecrypt().'</p>'
          ]);
      } else {
            $messages = $validator->errors()->getMessages();

            return response()->json([
                'success' => false,
                'validator' => true,
                'message' => $messages
            ]);
        }  
    }

    /**
     * send groupfie
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendGroupfie(Request $request, NotificationMailer $mailer)
    {
        $reservation = $this->reservations->find($request->id);
        try {

          $mailer->sendGroupfieReservation($reservation);

        } catch (Exception $e){
           //
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showGroupfie($id, Request $request)
    {
        $reservation = $this->reservations->find($request->id);

        if ( $request->ajax() ) {
            return response()->json([
                'success' => true,
                'view' => view('reservations.show_groupfie', compact('reservation'))->render()
            ]);
        }

        return view('reservations.show_groupfie', compact('reservation'));
    }

    /**
     * update coupon groupfie
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateCouponGroupfie(Request $request)
    {
      $data = ['status' => 'Used'];
      $coupon = $this->coupons->update($request->id, $data);

      return response()->json([
          'success' => true,
          'message' => 'El cupón de la reservación #'.$request->reservation.', se ha cambiado su estado a USADO',
      ]); 
    }
}
