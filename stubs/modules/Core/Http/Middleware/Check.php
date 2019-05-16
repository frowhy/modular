<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Providers\Auth\Illuminate;

class Check extends BaseAuthenticate
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

        if ($this->auth->parser()->setRequest($request)->hasToken()) {
            try {
                $this->auth->parseToken()->authenticate();
            } catch (Exception $e) {
                //
            }
        }

        return $next($request);
    }
}
