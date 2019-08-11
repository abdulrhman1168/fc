<?php

namespace App\Classes\Sms;

use GuzzleHttp\Client;
use App\Classes\Sms\Sms;

class Mobily extends Sms
{

  /**
  * API URLS
  */
    protected static $sendMessageURL = "http://www.mobily.ws/api/msgSend.php";
    protected static $getBalanceURL = "http://www.mobily.ws/api/balance.php";

    /**
    * Send sms message
    * @param String $message
    * @param Array  $numbers
    * @return Array [ true => [], false => []] contains success and failed data
    */
    public static function send($message, $numbers)
    {
        $responses = [ true => [], false => []];
        $numbers_arrays = array_chunk(self::getWithCountryCode($numbers), 1000);

        foreach ($numbers_arrays as $numbers_array) {
            $string_numbers = join(',', $numbers_array);
            // Send message
            $response = self::sendMessage($message, $string_numbers);
            // Set response
            foreach ($numbers_array as $number) {
                $responses[$response["success"]][] = $number;
            }
        }

        return $responses;
    }

    /**
    * Send sms message
    * @param String $message
    * @param String  $numbers string comma seperated numbers
    * @return Array ['success' => , 'message' => '', 'responseCode' => ]
    */
    public static function sendMessage($message, $numbers)
    {
        $client = new Client();
        $response = $client->request(
        'POST',
        self::$sendMessageURL,
        [
                                            'form_params' => [
                                                'mobile' => env('MOBILY_USER_NAME'),
                                                'password' => env('MOBILY_PASSWORD'),
                                                'sender' => urlencode(env('MOBILY_SENDER')),
                                                'msg' => $message,
                                                'lang' => 3,
                                                'applicationType' => 68,
                                                'numbers' => $numbers,
                                                'timeSend' => 0,
                                                'dateSend' => 0,
                                            ]
                                          ]
                                        );

        return self::getStatusWithMessage($response->getBody()->getContents());
    }

    /**
    * Get SMS balance
    * @return Integer Sms balance
    */
    public static function getBalance()
    {
        $client = new Client();
        $response = $client->request(
        'GET',
        self::$getBalanceURL,
        [
                                            'query' => [
                                                'mobile' => env('MOBILY_USER_NAME'),
                                                'password' => env('MOBILY_PASSWORD')
                                            ]
                                          ]
                                        );

        return explode('/', trim(strip_tags($response->getBody()->getContents())));
    }

    /**
    * Get SMS current balance
    * @return Integer Sms balance
    */
    public static function getCurrentBalance()
    {
        $responseArray = self::GetBalance();
        //failure
        if (count($responseArray) == 1) {
            return 0;
            //success
        } else {
            return $responseArray[1];
        }
    }

    /**
    * Get message success or fail with message
    * @param String $responseCode returned response code
    */
    public static function getStatusWithMessage($responseCode)
    {
        switch ($responseCode) {
      case "1":
          return ["responseCode" => $responseCode, "success" => true, "message" => app('translator')->get('mobily.sent')];
      case "2":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.no_charge_zero')];
      case "3":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.no_charge')];
      case "4":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.null_user_or_mobile')];
      case "5":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.wrong_password')];
      case "6":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.try_later')];
      case "13":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.sender_not_approval')];
      case "14":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.empty_sender')];
      case "15":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.empty_numbers')];
      case "16":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.empty_sender2')];
      case "17":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.message_not_encoding')];
      case "18":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.service_stoped')];
      case "19":
          return ["responseCode" => $responseCode, "success" => false, "message" => app('translator')->get('mobily.app_error')];
      }
    }
}
