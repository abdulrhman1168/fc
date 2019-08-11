<?php

namespace Modules\Auth\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Classes\AzureAuthentication;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
      if (!Auth::guard($guard)->check()) {

          if (env('AUTH_METHOD') == 'azure') {

            return redirect(AzureAuthentication::getAuthorizationURL());

          } else {

            return redirect()->route('login');

          }
      }

      return $next($request);
    }
}
