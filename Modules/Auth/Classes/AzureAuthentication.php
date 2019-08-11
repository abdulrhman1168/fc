<?php
namespace Modules\Auth\Classes;

use Redirect;

class AzureAuthentication
{

  /**
   * Redirect to authentication provider
   * @return Boolean
   */
    public static function getAuthorizationURL()
    {
        session(['azure_sso_state' => rand()]);

        $url = "https://login.microsoftonline.com/". env('AZURE_TENANT_ID') ."/oauth2/authorize?".
             "resource=". env('AZURE_RESOURCE') .
             "&client_id=". env('AZURE_CLIENT_ID') .
             "&response_type=id_token+code".
             "&redirect_uri=". urlencode(env('AZURE_REDIRECT_URI')).
             "&response_mode=". env('AZURE_RESPONSE_MODE').
             "&scope=openid%20profile&nonce=7362CAEA-9CA5-4B43-9BA3-34D7C303EBA7".
             "&state=". session('azure_sso_state');

        return $url;
    }

    /**
     * Get Access Token
     * @param String $code auth code to get access token
     * @return String $accessToken
     */
    public static function getAccessToken($code)
    {
      $accessToKenUrl = "https://login.microsoftonline.com/". env('AZURE_TENANT_ID') ."/oauth2/token";

      $data = [
        'grant_type' => 'authorization_code',
        'client_id' => env('AZURE_CLIENT_ID'),
        'client_secret' => env('AZURE_CLIENT_SECRET'),
        'client_id' => env('AZURE_CLIENT_ID'),
        'code' => $code,
        'redirect_uri' => env('AZURE_REDIRECT_URI')
      ];

      $curl = curl_init($accessToKenUrl);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($curl);
      curl_close($curl);
      $response = json_decode($response, true);

      return $response['access_token'];
    }

    /**
     * Get User email
     * @param String $accessToken
     * @return String $email user mail
     */
    public static function getUserMail($accessToken)
    {
      $graphUrl = "https://graph.microsoft.com/v1.0/me";

      $curl = curl_init($graphUrl);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $accessToken));
      $response = curl_exec($curl);
      curl_close($curl);

      $response = json_decode($response, true);

      return $response['mail'];
    }

    /**
     * Authorize user
     * @param Request $request
     * @return user mail of authorized
     * @return Boolean false if not authorized
     */
    public static function authorize($request)
    {
        if ($request->state == session('azure_sso_state')) {

          $accessToken = self::getAccessToken($request->code);

          return self::getUserMail($accessToken);

        } else {
            return false;
        }
    }



}
