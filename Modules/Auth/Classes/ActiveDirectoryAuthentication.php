<?php
namespace Modules\Auth\Classes;

use Modules\Auth\Interfaces\AuthenticationProvider;
use Exception;

class ActiveDirectoryAuthentication implements AuthenticationProvider
{

  /**
   * Authenticate user via active_directory provider
   * @param Array $credentials['email' => $email, 'password' => $password]
   * @return Boolean
   */
    public static function authenticate($credentials)
    {
        try {
            $username = explode('@', $credentials['email'])[0];
            $connection = ldap_connect(env('LDAP_HOST'), env('LDAP_PORT'));
            ldap_bind($connection, env('LDAP_USER') . '@' . env('LDAP_DOMAIN'), env('LDAP_PASS'));
            ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
            return ldap_bind($connection, $username . '@' . env('LDAP_DOMAIN'), $credentials['password']);

        } catch (Exception $ex) {
            return false;
        }
    }
}
