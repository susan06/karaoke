<?php

namespace App\Http\Middleware;

use Session;
use URL;
use Closure;
use App\BranchOffice;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route_previus = URL::previous();
        $reservation = strpos($route_previus, 'reservations-store');
        if($reservation) {
            session()->put('to_reservation', 'reservations-store');
            $branch_offices = BranchOffice::all();
            $branch_office = BranchOffice::first();
            session()->put('branch_office', $branch_office); 
            if ( count($branch_offices) > 1) {
                $list = ['' => trans('app.select_a_branch_office')] + BranchOffice::where('status', 1)->pluck('name', 'id')->all();
                session()->put('branch_offices', $list); 
            } 
        }
        if ($this->auth->check()) {
            return redirect('/dashboard');
        }
        
        return $next($request);
    }
}
