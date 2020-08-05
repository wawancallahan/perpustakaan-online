<?php

namespace App\Http\Middleware;

use Closure;

class SiswaActiveMiddleware
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
        if (auth()->user()->is_active == 0) {
            return response()->view('siswa.non_active');
        }

        return $next($request);
    }
}
