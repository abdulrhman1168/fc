<?php
namespace App\Classes\Sms;

class Sms
{
    /**
    * Return mobile with country code
    * @param array $numbers
    * @param String prefix for numbers ex: 00 or 0 or +
    * @return String mobile with country code
    */
    public static function getWithCountryCode($numbers, $prefix = null)
    {
        $numbersWithCountryCode = [];

        foreach ($numbers as $number) {
            if (preg_match('/^(9665[0-9]{8})/', $number)) {
                $numbersWithCountryCode[] = $number;
            } else {
                $number = '966' . preg_replace('/^(00966|\+966|966|0966|0)/', '', trim($number));

                if ($prefix != null) {
                    $number = $prefix . $number;
                }

                $numbersWithCountryCode[] = $number;
            }
        }
        return $numbersWithCountryCode;
    }
}
