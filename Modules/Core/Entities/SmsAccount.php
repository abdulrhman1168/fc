<?php
namespace Modules\Core\Entities;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Classes\Sms\Mobily;
use Illuminate\Database\Eloquent\Model;

class SmsAccount extends Model
{
    use SoftDeletes;

    /**
     * Static variables
     *
     * @var string
     */
     protected static $publicRelationAccount = 'Public relations';


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_accounts';

    /**
     * Get account by name
     * @param Object account
     */
    public static function getByName($accountName)
    {
      return self::where('name', '=', $accountName)->first();
    }

    /**
    * Get public relations account
    */
    public static function getPublicRelationsAccount()
    {
      return self::getByName(self::$publicRelationAccount);
    }

    /**
    * Get account driver
    * @param Integer account id
    * Class extends SMS
    */
    public static function getDriver($account = 'Public relations')
    {
      // if ($account->name == self::$publicRelationAccount) {
      // }
      return Mobily::class;
    }
}
