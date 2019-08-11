<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        \Modules\Core\Http\Middleware\ArabicNumbersMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SetCurrentLanguage::class
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
            \App\Http\Middleware\SetCurrentLanguage::class
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Modules\Auth\Http\Middleware\RedirectIfAuthenticated::class,
        'auth-user' => \Modules\Auth\Http\Middleware\RedirectIfNotAuthenticated::class,
        'authorize' => \Modules\Core\Http\Middleware\Authorize::class,
        'auth-employee' => \Modules\Employees\Http\Middleware\Employee::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'validate-user-is-super-admin' => \App\Http\Middleware\ValidateUserIsSuperAdmin::class,
        'only-non-saudi' => \Modules\MyServices\Http\Middleware\AllowOnlyNonSaudi::class,
        'VerifyAppIDAppSecret' => \Modules\API\Http\Middleware\VerifyAppIDAppSecret::class,
    ];
}