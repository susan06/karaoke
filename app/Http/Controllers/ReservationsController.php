<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReservationsController extends Controller
{
     /**
     * Display reservations today.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('reservations.index');
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

}
