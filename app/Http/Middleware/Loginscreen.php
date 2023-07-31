<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class Loginscreen
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
        $addmember_form = Session::get('addmember_form');
       
        if(!empty($addmember_form)){
            return redirect('notaccess');
        }
        return $next($request);
    }
}
