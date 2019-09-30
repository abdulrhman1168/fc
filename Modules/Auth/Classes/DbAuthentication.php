<?php
namespace Modules\Auth\Classes;

use Modules\Auth\Interfaces\AuthenticationProvider;
use Modules\Auth\Entities\Core\User;
use Illuminate\Support\Facades\Hash;
class DbAuthentication implements AuthenticationProvider
{

  /**
   * Authenticate user via db provider
   * @param Array $credentials['email' => $email, 'password' => $password]
   * @return Boolean
   */
    public static function authenticate($credentials)
    {
      $user = User::where('user_mail', '=', $credentials['email'])->first();

      if ($user != null) {
          if ($user->password == md5($credentials['password'])) {
              return true;
          }
      }

      return false;
    }
}
