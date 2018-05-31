<?php

namespace BRamalho\LaravelUserPermissions;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserRoleMiddleware
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
