<?php

/*
|--------------------------------------------------------------------------
| Middleware Routes
|--------------------------------------------------------------------------
*/

return [
    'scope' => \Modules\Core\Http\Middleware\CheckForAnyScope::class,
    'scopes' => \Modules\Core\Http\Middleware\CheckScopes::class,
    'jwt-auth' => \Modules\Core\Http\Middleware\Authenticate::class,
    'jwt-check' => \Modules\Core\Http\Middleware\Check::class,
    'jwt-refresh' => \Modules\Core\Http\Middleware\RefreshToken::class,
    'jwt-renew' => \Modules\Core\Http\Middleware\AuthenticateAndRenew::class,
];
