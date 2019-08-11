<?php

namespace App\Http\Middleware;

use Closure;
use App;

class SetCurrentLanguage
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
      // Set default locale.
      $locale = config('app.locale');

      // locale present and valid
      $isValidUrlLocale = ($request->has('lang') && in_array($request->query('lang'), config('app.locales')));

       // Priority for URL locale else use session locale
       if ($isValidUrlLocale) {
         $locale = $request->query('lang');
       } else if (session()->has('locale') ) {
         $locale = session('locale');
       }

       // set app locale
       App::setLocale($locale);

       return $next($request);
    }
}
