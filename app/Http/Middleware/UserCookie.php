<?php

namespace App\Http\Middleware;

use Closure;

class UserCookie
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
        if ( $request->cookie('_ub_') === null ){
            $reponse = $next($request);
            $cookie = str_random(24) . '|' . time();
            return $reponse->withCookie(cookie()->forever( '_ub_', $cookie ));
        } else {
            return $next($request);
        }
    }
}
