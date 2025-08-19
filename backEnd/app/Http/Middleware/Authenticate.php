<?php

namespace App\Http\Middleware;

use DomainException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

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
//        if (! $request->expectsJson()) {
//            return route('login');
//        }
        return;
    }

    /**
     * this method is overwritten not triggering the above method
     * @param $request
     * @param array $guards
     * @return mixed
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new DomainException('Faça login para continuar!', 401);
    }
}
