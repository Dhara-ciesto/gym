<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class Checkip
{
    public $whiteIps = ['192.168.1.1', '127.0.0.1'];
    // public $whiteIps = ['192.168.1.1'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // if (!in_array($request->ip(), $this->whiteIps)) {
        //     abort(404, 'Page not found');
        //     return response()->json(['your ip address is not valid.']);
        // }

        return $next($request);
    }
}
