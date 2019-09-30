<?php
namespace Modules\DepartmentServices\Entities\Authorization;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\SharedModel;
use Modules\Core\Entities\Core\App;

class AuthorizationPermission extends Model
{
    use SharedModel;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table      = 'authorization_permissions';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable   = [
        'auth_id', 'app_id'
    ];

    /**
     * get authorization employee data
     */
    public function authorizationEmployee()
    {
        return $this->belongsTo(AuthorizationEmployee::class, 'id', 'auth_id');
    }

    /**
     * get app data
     */
    public function app()
    {
        return $this->hasOne(App::class, 'id', 'app_id');
    }


    /**
    * get core main apps for department services
    */
    public static function mainDepartmentServicesApps($appsID = [])
    {
        $appsData =  App::parentsFormMenu(App::$unifiedResourceNames['department_services']);
        
        if(!empty($appsID)) {
            $appsData = $appsData->whereIn(App::table().'.id', $appsID);
        }

        return $appsData->get();
    }


    /**
    * get core apps for department services
    */
    public static function departmentServicesApps()
    {
        $authorizedAppIds = auth()->user()->authorizedAppsIds();
        App::setAuthorizedApps($authorizedAppIds);

        return App::parentsFormMenu(App::$unifiedResourceNames['department_services'])
                       ->whereIn('resource_name', [
                           'Modules\DepartmentServices\Http\Controllers\Attendance\VacationsController@index',
                           'Modules\DepartmentServices\Http\Controllers\Attendance\PermissionsRequestsController@index'
                       ])
                       ->with('menuChildrenRecursive')
                       ->get();
    }

}
