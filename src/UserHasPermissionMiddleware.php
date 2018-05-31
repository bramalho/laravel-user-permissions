<?php

namespace BRamalho\LaravelUserPermissions;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserHasPermissionMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @param $module
     * @param $action
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next, $module, $action)
    {
        if (Auth::guest() || !Auth::user()->hasPermission($module, $action)) {
            return redirect()->to('/');
        }

        return $next($request);
    }
}
