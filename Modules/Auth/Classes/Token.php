<?php
namespace App\Classes\Auth;

use Carbon\Carbon;

/**
 * contains common translation methods
 */
class Token
{

  /**
   * Generate token with specified length
   * @param String $length token length
   * @return String $token token string
   */
    public static function generate($length)
    {
        $token = md5(microtime().rand());

        return ($length == null ? $token : substr($token, 0, $length));
    }

    /**
     * Verify tokens
     * @param $token1 token to be verified
     * @param $token1 token to be verified against
     * @param $created_at token to be verfified datetime creation
     * @param $expire_after number of minutes token to be expired
     * @return Boolean boolean value indicate success or fail of verification
     */
    public static function verify($token1, $token2, $createdAt, $expireAfter = false)
    {
        if ($token1 == $token2) {
            if ($expireAfter) {
                $activeMinutes = $createdAt->diffInMinutes(Carbon::now());
                if ($activeMinutes < $expireAfter) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
