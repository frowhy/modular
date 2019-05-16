<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Providers\Auth\Illuminate;

class RefreshToken extends BaseAuthenticate
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

        $this->checkForToken($request);

        try {
            $token = $this->auth->parseToken()->refresh();
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }

        $response = $next($request);

        // Send the refreshed token back to the client.
        return $this->setAuthenticationHeader($response, $token);
    }
}
