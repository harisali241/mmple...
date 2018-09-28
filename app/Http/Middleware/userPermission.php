<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class userPermission
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
       if(!checkUserPermission()){
            if(Auth::user()->id == 1){
                return $next($request);
            }
            return redirect()->back()->withErrors('Access Denied');
            //return abort(408);
       }
        return $next($request);
    }
}
