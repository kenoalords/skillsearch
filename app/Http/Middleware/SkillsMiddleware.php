<?php

namespace App\Http\Middleware;

use Closure;

class SkillsMiddleware
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
        if ( $request->user()->skills->count() === 0 ){
            return redirect( route('edit_profile') )->with('error', 'Please select your skills in other to share your portfolio');
        }
        return $next($request);
    }
}
