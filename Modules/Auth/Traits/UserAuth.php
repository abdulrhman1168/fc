<?php
namespace Modules\Auth\Traits;

use Modules\Auth\Classes\DbAuthentication;
use Modules\Auth\Classes\ActiveDirectoryAuthentication;

trait UserAuth
{
  /**
   * Check if user credentials is valid
   * @param Array $credentials
   * @return Modules\Auth\Entities\Core\User in case of success
   * @return Boolean false in case of failure
   */
   public static function isValidCredentials($credentials)
   {
     $auth_provider = env('AUTH_METHOD', 'db');
     $api_auth_provider = env('API_AUTH_METHOD', 'db');
     $user = self::where('user_mail', $credentials['email'])->first();
    
     if ($user == null ) {
       return false;
     }

     if ($auth_provider == 'db' || $api_auth_provider == 'db') {
       
       return (DbAuthentication::authenticate($credentials) ? $user : false);
     }  else {
       return false;
     }
   }
}
