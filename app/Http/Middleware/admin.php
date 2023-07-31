<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use DB;

class admin
{
    protected $auth;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
        $this->auth = Session::get('role');
        $addmember_form = Session::get('addmember_form');
        if (!empty($addmember_form)) {
            return redirect('notaccess');
        }
        if ($this->auth) {
            $role_data = DB::table('roles')->where('employeerole', $this->auth = Session::get('role'))->first();

            if (!empty($role_data)) {
                $is_login = $role_data->portalaccess;
                if ($is_login != 1) {
                    return redirect('adminloginpage');
                } else {
                    return $next($request);
                }
            } else {
                return $next($request);
            }
        } else {
            return redirect('adminloginpage');
        }
    }
}
