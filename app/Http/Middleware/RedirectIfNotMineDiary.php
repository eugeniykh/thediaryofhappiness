<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotMineDiary
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
        $userId = User::getId();
        if (!$userId || $request->route('diary')->user_id !== $userId) {
            return redirect()->action('HomeController@flow');
        }

        return $next($request);
    }
}
