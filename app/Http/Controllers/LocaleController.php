<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
  /**
   * Change current locale.
   *
   * @return void
   */
  public function change(Request $request, $locale)
  {
    if (in_array($locale, config('app.locales'))) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return back()->withInput();
  }
}
