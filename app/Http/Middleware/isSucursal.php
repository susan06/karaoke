<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class isSucursal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session('branch_office') == null) {
            if(Auth::user()->hasRole('user')) {
              return Redirect()->route('song.search');
            } else {
              return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
