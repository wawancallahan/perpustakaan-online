<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::check()) {

                $role = Auth::user()->roles->first()->name ?? null;
    
                switch ($role) {
                    case 'admin':
                    case 'petugas':
                        return redirect()->route('admin.dashboard');
                    break;
                    case 'siswa':
                        return redirect()->route('siswa.dashboard');
                    break;
                    case 'headmaster':
                        return redirect()->route('headmaster.dashboard');
                    break;
                }
            }

            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
