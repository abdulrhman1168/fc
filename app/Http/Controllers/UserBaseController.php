<?php

namespace App\Http\Controllers;

use Route;

use Illuminate\Http\Request;
use Modules\Core\Traits\StoreFile;

class UserBaseController extends Controller
{

  use StoreFile;

  public $isApiCall = false;

  public $requestSource = null;

  /**
  * will include array of controllers that generic middleware not run
  * @var array
  */
  private $exceptAuthorizeControllers = [
      'Modules\Auth\Http\Controllers\AuthController@showLoginForm',
      'Modules\Auth\Http\Controllers\AuthController@login',
      'App\Http\Controllers\Index\HomeController@index',
      'App\Http\Controllers\Index\HomeController@updateMenuStatus',

      
  ];

  /**
   * Create a New controller instance.
   *
   * @return void
   */
  public function __construct(Request $request)
  {  

    if ($request->call_type == "api") {

      $this->middleware('auth:api');
      $this->isApiCall = true;
      $this->requestSource = "app";

    } else {

      $this->requestSource = "web";
      $this->middleware('auth-user');
    }
    
      if (!$this->isInExceptAuthorizeControllers()) {
          $this->middleware('authorize');
      }

  }






  /**
  * Check if current request Controller exist in except array
  * @return true if exist
  * @return false if not exist
  */
  public function isInExceptAuthorizeControllers()
  {
    if (in_array(Route::currentRouteAction(), $this->exceptAuthorizeControllers)) {
      return true;
    } else {
      return false;
    }
  }
}
