<?php
namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Sms\Mobily;
use Modules\Core\Entities\SmsAccount;
use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['sms_account_id', 'user_id', 'message', 'numbers', 'status'];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
       // array of numbers which messagen sent
       'numbers' => 'array',
       /**
       * array of message status [ true => ['number', ..], false => ['number',..]]
       * true => numbers which message delivered.
       * false => numbers which message failed to deliver.
       */
       'status' => 'array'
   ];

    /**
     * Get sms sender
     * @param Object account
     */
    public function sender()
    {
      return $this->belongsTo('Modules\Auth\Entities\Core\User');
    }

    /**
     * Get sms account
     * @param Object account
     */
    public function account()
    {
      return $this->belongsTo('Modules\Core\Entities\SmsAccount', 'sms_account_id');
    }

    /**
     * Register things required on boot
     */
     public static function boot() {
       parent::boot();

       /*
       * Handle events on create
       */
       static::creating(function($sms) {
         $driver = SmsAccount::getDriver();
         $status = $driver::send($sms->message, $sms->numbers);
         $sms->status = $status;
       });

     }
}
