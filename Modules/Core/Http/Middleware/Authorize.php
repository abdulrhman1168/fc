<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Route;

class Authorize
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    if (!$request->user()->is_super_admin) {
      $permission = $request->user()->hasPermission(Route::currentRouteAction());

      if(!$permission)
      {
        if ($request->wantsJson() || $request->ajax()) {
          $message = ['message' => app('translator')->get('messages.unauthorized_user')];
          return response($message, 401);
        } else {
          return  redirect()->route('un_authorized_user');
        }
      }

      $request->user()->setCurrentPermission($permission);
    }

    return $next($request);
  }
}
