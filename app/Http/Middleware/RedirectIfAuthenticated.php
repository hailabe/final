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
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                   return redirect()->route('admin.dashboard');
                }
                break;
            case 'salesstaff':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('salesstaff.dashboard');
                }
                break;
            case 'artist':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('artist.dashboard');
                }
                break;
            case 'producer':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('producer.dashboard');
                }
                break;
            
            default:
                if (Auth::guard($guard)->check()) {
                   return redirect()->route('/home');
                }
                break;
        }
        

        return $next($request);
    }
}
