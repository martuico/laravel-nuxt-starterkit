<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        $e = new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );

        // dingo-api will throw http 500 unless we wrap it in a HTTPException
        if ($request->expectsJson()) {
            $e = new UnauthorizedHttpException("", null, $e);
        }
        throw $e;
    }
}
