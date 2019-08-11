<?php
namespace Modules\Core\Traits;

use Modules\Core\Entities\Core\Group;
use Modules\Core\Entities\Core\Permission;
use Modules\Core\Entities\Core\App;
use Modules\DepartmentServices\Entities\Authorization\AuthorizationEmployee;

trait AuthorizeUser
{
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var Object permission
     */
    public $currentPermission = null;

    /**
      * Set current permission
      * @param Permission $currentPermission
      */
    public function setCurrentPermission($currentPermission)
    {
        $this->currentPermission = $currentPermission;
    }

    /**
     * Return all user own permissions in addition to user groups permissions
     * @param Integer $app_id
     */
    public function allPermissions($app_id = false)
    {
        $userPermissions = $this->permissions();
        $groupPermissions = Permission::queryByGroupIds($this->groups()->pluck(Group::table().'.id'));
        $delegationIds = AuthorizationEmployee::where('auth_employee_id', '=', optional($this->employeeObject)->employee_id)->pluck('id')->toArray();
        $delegatedPermissions = Permission::queryDelegatedPermissionsByDelegatationIds($delegationIds);

        if ($app_id != false) {
            $userPermissions =  $userPermissions->where('app_id', $app_id);
            $groupPermissions = $groupPermissions->where('app_id', $app_id);
            $delegatedPermissions = $delegatedPermissions->where('app_id', $app_id);
        }
        
        $allPermissions = $userPermissions->union($groupPermissions)->union($delegatedPermissions);

        return $allPermissions;
    }


    /**
      * Check if user has a permission for a specified resource name
      * @param String namespaced resource name
      * @return permission if true
      * @return false if not found
      */
    public function hasPermission($resourceName)
    {
        $app = App::where('resource_name', $resourceName)->first();

        if ($app == null) {
            return false;
        }


        $permissions = $this->allPermissions($app->id)->get();

        $groupsPermissionsByAcessLevel = [];

        foreach ($permissions as $permission) {
            if ($permission->isUserPermission()) {
                return $permission;
            } elseif ($permission->isGroupPermission()) {
                $groupsPermissionsByAcessLevel[$permission->access_level] = $permission;
            } elseif($permission->isDelegatedPermission()) {

                return $permission;
            }
        }


        if (array_key_exists("all", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["all"];
        } elseif (array_key_exists("dept", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["dept"];
        } elseif (array_key_exists("me", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["me"];
        } elseif (array_key_exists("scope", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["scope"];
        } elseif (array_key_exists("collage", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["collage"];
        } elseif (array_key_exists("manager", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["manager"];
        } elseif (array_key_exists("dean", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["dean"];
        } elseif (array_key_exists("vice_dean", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["vice_dean"];
        } elseif (array_key_exists("direct_manager", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["direct_manager"];
        } elseif (array_key_exists("parent_manager", $groupsPermissionsByAcessLevel)) {
            return $groupsPermissionsByAcessLevel["parent_manager"];
        }
        

        return false;
    }

    /**
       * Check if user has a permission with specified access
       * @param String namespaced resource name
       * @param String access
       * @return permission if true
       * @return false if not found
       */
    public function hasPermissionWithAccess($reourceName, $accessLevel)
    {
        $permission = $this->hasPermission($reourceName);

        if ($permission) {
            if ($permission->access_level == $accessLevel) {
                return $permission;
            }
        }

        return false;
    }

    /**
     * Get User authorized apps ids
     * @param Array $excludedIds Ids to be execluded from arrray
     * @return Array authorized ids
     */
    public function authorizedAppsIds($excludedIds = [])
    {
        $ids = $this->allPermissions()->get()->pluck('app_id')->toArray();
        if (!empty($excludedIds)) {
            return array_diff($ids, $excludedIds);
        } else {
            return $ids;
        }
    }

    public function isAllAccess()
    {
        return optional($this->currentPermission)->access_level == "all";
    }

    public function isDirectManagerAccess()
    {
        return optional($this->currentPermission)->access_level == "direct_manager";
    }

    public function isParentManagerAccess()
    {
        return optional($this->currentPermission)->access_level == "parent_manager";
    }
}
