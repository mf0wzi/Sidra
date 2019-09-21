<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AuthLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // If the user does not have this feature enabled, then just return next.
            if (!$request->user()) {
                return $next($request);
            }

            if (!Cache::has('user-is-active-' . $request->user()->id)) {
                Cache::forget('user-is-active-' . $request->user()->id);
                return redirect()->route('login.locked');
            } else {
                $expiresAt = Carbon::now()->addMinutes(15);
                Cache::put('user-is-active-' . $request->user()->id, true, $expiresAt);
            }
        }

        return $next($request);
    }
}
