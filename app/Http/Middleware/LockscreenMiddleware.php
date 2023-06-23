<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cache;

class LockscreenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Cache::has('active_'.auth()->user()->_id))
        {
            Cache::forever('active_'.auth()->user()->_id,true);
            return $next($request);
        }

        return redirect()->route('lockscreen');
        
    }
}
