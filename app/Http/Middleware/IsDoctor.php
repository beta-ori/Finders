<?php

namespace App\Http\Middleware;

use Closure;

class IsDoctor
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
        if(auth()->user()->is_doctor == 1){
            return $next($request);
        }
        return redirect('pages.home')->with(‘error’,"You don't have admin access.");
    }
}
