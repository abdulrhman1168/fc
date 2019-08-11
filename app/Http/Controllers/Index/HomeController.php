<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\UserBaseController;

use Illuminate\Http\Request;


class HomeController extends UserBaseController
{

  /**
   * Return view index.
   *
   * @return void
   */
  public function index(Request $request)
  {

 

 


    return view('index.index');
  }

  public function updateMenuStatus(Request $request)
  {
    auth()->user()->update([
      'menu_status' => !auth()->user()->menu_status,
    ]);
    return response()->json(200);
  }
}
