<?php

namespace App\Http\Middleware;

use Closure;

class CheckVerify
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
        $verify_check = $request->user()->verifyUser()->get()->first();

        if($verify_check){
            return redirect()->route('verify');
        }

        return $next($request);
    }
}
