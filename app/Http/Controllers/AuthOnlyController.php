<?php

namespace App\Http\Controllers;


class AuthOnlyController extends Controller
{
  /**
   * Create a New controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth-user');
  }
}
