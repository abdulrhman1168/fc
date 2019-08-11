<?php

use Modules\Core\Entities\SmsAccount;
use Modules\Core\Entities\Sms;
use App\Classes\Date\Hijri;
use Modules\Auth\Entities\Core\User;

use App\Classes\Date\CarbonHijri;

use Carbon\Carbon;

/**
* Send SMS
* @param String $message
* @param Array $numbers
*/
function sendSms($message, $numbers) {

  if (empty($message) || empty($numbers) || !is_array($numbers)) {
    return "Please provide string message and array of numbers parameters";
  }

  $sms = new Sms;
  $sms->user_id = (Auth::user() == null ? '1234567' : Auth::user()->user_id);
  $sms->account()->associate(SmsAccount::getPublicRelationsAccount());
  $sms->message = $message;
  $sms->numbers = $numbers;
  $sms->save();
}


/**
* Convert Date to hijri
* Date in format Y-m-d
* @return Hijri date
*/
function toHijri($date) {
  return Hijri::toHijri($date);
}

function getUserById($id)
{
  return User::find($id);
}

function todayHijriDate()
{
  return CarbonHijri::now()->hijriFormat('Y-m-d');
}

function todayDate()
{
  return Carbon::now()->format('y-m-d');
}

function isPresent($val) {

  return isset($val) && $val != null;
}

function oldOrValueInArrayExist($val, $oldVal, $arrValues) 
{
  if (isPresent($val) && isPresent($arrValues)) {

    if (in_array($val, $arrValues)) {

      return true;

    } else {
      return false;
    }
  } else if ($oldVal == $val) {

      return true;

    } else {

      return false;

    }
}


