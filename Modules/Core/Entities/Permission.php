<?php
namespace Modules\Core\Entities\Core;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Core\User;

class Permission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'es_core_permissions';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['app_id', 'access_level'];

    /**
     * Available permissionable models
     *
     * @var array
     */
    public static $availablePermissionables = [
     'users' => ['mu_users,user_id', 'Modules\Auth\Entities\Core\User'],
     'groups' => ['es_core_groups,id', 'Modules\Core\Entities\Core\Group'],
     'delegation' => ['authorization_employee,id', 'Modules\DepartmentServices\Entities\Authorization\AuthorizationEmployee']
   ];

    /**
     * Available access levels
     *
     * @var array
     */
    public static $availableAccessLevels = [
        'all', 
        'dept', 
        'me', 
        'scope', 
        'collage', 
        'manager', 
        'dean', 
        'vice_dean',
        'direct_manager', 
        'parent_manager'
    ];

    /**
     * Get permissionable
     */
    public function permissionable()
    {
        return $this->morphTo();
    }

    /**
     * Get by group ids
     * @param Array groups ids
     */
    public static function queryByGroupIds($groupIds)
    {
        return self::where('permissionable_type', self::$availablePermissionables["groups"][1])
               ->whereIn('permissionable_id', $groupIds);
    }

    public static function queryDelegatedPermissionsByDelegatationIds($delegationIds)
    {
        return self::where('permissionable_type', self::$availablePermissionables["delegation"][1])
               ->whereIn('permissionable_id', $delegationIds);
    }



    /**
     * Get permissionable models as comma seperated string
     */
    public static function permissionablesToString()
    {
        return join(',', array_keys(self::$availablePermissionables));
    }
    
    /**
     * Get permissionable table and key
     */
    public static function getPermissionableExistsRule($permissionable)
    {
        if (array_key_exists($permissionable, self::$availablePermissionables)) {
            return '|exists:'. self::$availablePermissionables[$permissionable][0];
        } else {
            return '';
        }
    }

    /*
    * Check if group permisison
    */
    public function isGroupPermission()
    {
        if ($this->permissionable_type == self::$availablePermissionables["groups"][1]) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * Check if user permisison
    */
    public function isUserPermission()
    {
        if ($this->permissionable_type == self::$availablePermissionables["users"][1]) {
            return true;
        } else {
            return false;
        }
    }

    /*
    * Check if user permisison
    */
    public function isDelegatedPermission()
    {
        if ($this->permissionable_type == self::$availablePermissionables["delegation"][1]) {
            return true;
        } else {
            return false;
        }
    }

    public static function accessLevels()
    {
        return [
             'all'              =>  __('messages.all'),
             'collage'          =>  __('messages.collage'),
             'dept'             =>  __('messages.dept'),
             'me'               =>  __('messages.me'),
             'direct_manager'   =>  __('messages.direct_manager'),
             'parent_manager'   =>  __('messages.parent_manager'),
             'manager'          =>  __('messages.manager'),
             'dean'             =>  __('messages.dean'),
             'vice_dean'        =>  __('messages.vice_dean'),
             'scope'            =>  __('messages.scope'),
         ];
    }

}
