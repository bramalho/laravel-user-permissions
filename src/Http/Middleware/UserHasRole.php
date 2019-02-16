<?php

namespace BRamalho\LaravelUserPermissions\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserHasRole
{
    /**
     * @param $request
     * @param Closure $next
     * @param string $role
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guest() || !Auth::user()->hasRole($role)) {
            return redirect()->to('/');
        }

        return $next($request);
    }
}
