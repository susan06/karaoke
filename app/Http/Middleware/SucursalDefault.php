<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Session;
use Illuminate\Contracts\Auth\Guard;
use App\BranchOffice;

class SucursalDefault
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
        if ($this->auth->check()) {
            if(session('branch_office') == null) {
                if(Auth::user()->hasRole('user')) {
                  return Redirect()->route('song.search');
                } else {
                  return redirect()->route('dashboard');
                }
            }

            return $next($request);

        } else {
            $branch_offices = BranchOffice::all();
            $branch_office = BranchOffice::first();
            session()->put('branch_office', $branch_office); 
            if ( count($branch_offices) > 1) {
                $list = ['' => trans('app.select_a_branch_office')] + BranchOffice::where('status', 1)->pluck('name', 'id')->all();
                session()->put('branch_offices', $list); 
            } 
        }

    }
}
