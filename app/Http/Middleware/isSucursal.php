<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class isSucursal
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
        } else {

            return redirect()->guest('login');
        }

        //return $next($request);
    }
}
