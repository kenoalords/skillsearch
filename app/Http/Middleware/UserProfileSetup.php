<?php

namespace App\Http\Middleware;

use Closure;

class UserProfileSetup
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
        $profile = $request->user()->profile()->get();
        // dd($profile->count());
        
        if($profile->count() === 0){
            return redirect()->route('start');
        }

        return $next($request);
    }
}
