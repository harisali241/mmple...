<?php

namespace App\Http\Middleware;

use Closure;

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
            return redirect()->back()->withErrors('Access Denied');
            //return abort(408);
       }
        return $next($request);
    }
}
