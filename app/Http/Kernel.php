<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'         => \App\Http\Middleware\Authenticate::class,
        'auth.basic'   => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'        => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'authority'    => \App\Http\Middleware\AuthorityAuthenticate::class,
        'permission'   => \App\Http\Middleware\SystemManager::class,
        'pathsession'  => \App\Http\Middleware\DirectionPathSession::class,
        'usersession'  => \App\Http\Middleware\UsernameSession::class,
        'role'         => \Zizaco\Entrust\Middleware\EntrustRole::class,
        'permissions'  => \Zizaco\Entrust\Middleware\EntrustPermission::class,
        'ability'      => \Zizaco\Entrust\Middleware\EntrustAbility::class,
    ];
}
