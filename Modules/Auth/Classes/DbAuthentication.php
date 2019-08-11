<?php
namespace Modules\Auth\Classes;

use Modules\Auth\Interfaces\AuthenticationProvider;
use Modules\Auth\Entities\Core\User;

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
            
            if ($user->user_mail == $credentials['email']) {
                
                return true;
            }

          //  dd($user->user_password);
        }

        return false;
    }
}
