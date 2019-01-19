<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Profile;

class ProfileMiddleware
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
        $profile = $request->user()->profile;
        if ( $profile->bio === null || $profile->location === null ){
            return redirect( route('edit_profile') )->with('status', 'You need to complete your profile before adding items to your portfolio. It only takes a minute');
        }
        return $next($request);
    }
}
