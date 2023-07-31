<?php

namespace App\Http\Middleware;

use Closure;
use App\Member;
use Illuminate\Http\Request;

class AppLogin
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
        $header = $request->header('AuthorizationKey');
        if ($header) {
            $member = Member::where('memberid', $header)->where('status', 1)->get()->first();
            if ($member) {
                return $next($request);
            } else {
                return response()->json(['Member not found.']);
            }
        }
        return response()->json(['Please provide authorization key.']);
    }
}
