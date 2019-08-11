<?php
namespace App\Classes\PushNotification;
use GuzzleHttp\Client as GuzzleClient;

class PushNotification
{
    protected static $pushNotification = "https://exp.host/--/api/v2/push/send";

    public static function  getNotifi ($to , $body)  {
        $guzzleClient = new GuzzleClient();
        $response = $guzzleClient->request('POST',self::$pushNotification, [
                    
                    'form_params' => [
                        'to' => $to,
                        'title' => 'خدمات الموظفين - نادي الفيصلص',
                        'body'  => $body,
                        'sound'=> 'default'
                        
                    ]
                ]);
                $responseText = $response->getBody()->getContents();

    }
    public static function PushArray($to, $body)
    {
       // $responses = [ true => [], false => []];
       $responses = [];
        $numbers_arrays = array($to);
        
        foreach ($numbers_arrays as $numbers_array) {
            $string_numbers = join(',', $numbers_array);
            // Send message
            $response = self::getNotifi($string_numbers, $body);
            // Set response
            foreach ($numbers_array as $to) {
                $responses[$response["success"]][] = $to;
            }
        }

        return $responses;
    }
}
