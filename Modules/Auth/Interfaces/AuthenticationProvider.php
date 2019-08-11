<?php
namespace Modules\Auth\Interfaces;

/**
 * Any Authentication service provider must implement this interface
 */
interface AuthenticationProvider
{

  /**
   * Authenticate user via provider EX: db or active_directory
   * @param Array $credentials['email' => $email, 'password' => $password]
   * @return Boolean
   */
   public static function authenticate($credentials);

}
