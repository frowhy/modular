<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Providers\Auth\Illuminate;

class AuthenticateAndRenew extends BaseAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @param $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        app()->singleton('tymon.jwt.auth', function () use ($guard) {
            return new JWTAuth(app('tymon.jwt.manager'), new Illuminate(auth($guard)), app('tymon.jwt.parser'));
        });

        $this->auth = app('tymon.jwt.auth');

        $this->authenticate($request);

        $response = $next($request);

        // Send the refreshed token back to the client.
        return $this->setAuthenticationHeader($response);
    }
}
