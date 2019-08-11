<?php
namespace Modules\Core\Entities\Core;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Core\User;
use Modules\Core\Entities\Core\Permission;
use Modules\Core\Entities\Core\Employee;
use Modules\Core\Entities\Core\Department;
use DB;


class Group extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'es_core_groups';

  /**
   * The attributes that are mass assignable
   *
   * @var array
   */
  protected $fillable = ['parent_id', 'name', 'name_en', 'key'];

  /**
   * unified groups keys
   *
   * @var array
   */
  public static $unifiedGroups = [
    'fc' => 'es_fc_group',
   
  ];


 /**
  * Get permissions specified for group
  */
 public function permissions()
 {
   return $this->morphMany(Permission::class, 'permissionable');
 }

 /**
  * Get group users
  */
 public function users()
 {
   return $this->belongsToMany(User::class, 'es_core_users_groups', 'es_core_group_id', 'user_id');
 }

 /**
  * Return Table Name
  */
  public static function table()
  {
      return with(new static)->getTable();
  }

  public static function findByKey($key)
  {
    return self::where('key', '=' ,$key)->first();
  }

  public static function findUnifiedGroupByName($name)
  {
    return self::findByKey(self::$unifiedGroups[$name]);
  }

  public static function syncFcGroup()
  {
      // $usersIds = User::on('oracle')->pluck('user_id')->toArray();
      $usersIds = User::pluck('user_id')->toArray();
      $group = self::findUnifiedGroupByName('fc');
      $group->users()->sync($usersIds);
  }

  




  public static function syncUsersUnifiedGroups()
  {
      self::syncFcGroup();
    
  }

  public static function hasUserByKey($key, $user)
  {
    $group = self::findByKey($key);

    return $group->hasUser($user);
  }

  public function hasUser($user)
  {
    $user = $this->users()
                  ->where(User::table().'.user_id', '=', $user->user_id)
                  ->first();

    return ($user == null ? false : true);
  }
}