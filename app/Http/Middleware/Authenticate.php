<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if (count($this->guards) > 0) {
                if ($this->guards[0] == 'admin') {
                    return route('auth.login.view');
                } else {
                    return route('auth-user.login.view');
                }
            }
        }
    }
}
