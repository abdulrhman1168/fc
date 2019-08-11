<?php
namespace Modules\DepartmentServices\Entities\Authorization;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\SharedModel;
use Modules\Core\Entities\Core\Employee;
use Carbon\Carbon;
use Modules\DepartmentServices\Entities\Authorization\AuthorizationPermission;
use Modules\Core\Entities\Core\Permission;
use Modules\Core\Entities\Core\App;

class AuthorizationEmployee extends Model
{
    use SharedModel;

    /**
     * values of auth status:
     * 0= New
     * 1= active
     * 2= stopped by the owner but still the employee has the permissions
     * 3= stopped by the owner but the employee dose not has permissions 
     * 4= ended 
    */

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table      = 'authorization_employees';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable   = [
        'employee_id', 'organization_id', 'auth_employee_id', 'from_date', 'to_date', 'auth_status'
    ];

    /**
     * dates fields 
     */
    protected $dates = ['from_date', 'to_date'];

    /**
     * get employee data 
     */
    public function employee()
    {
        return $this->belongsTo('Modules\Core\Entities\Core\Employee', 'employee_id', 'employee_id');
    }

    /**
     * get employee data 
     */
    public function authorizedEmployee()
    {
        return $this->belongsTo('Modules\Core\Entities\Core\Employee', 'auth_employee_id', 'employee_id');
    }

    /**
     * get organization data 
     */
    public function organization()
    {
        return $this->belongsTo('Modules\Core\Entities\Core\HRDepartment', 'organization_id', 'id');
    }

    /**
     * get authorization permissions data 
     */
    public function authorizationPermissions()
    {
        return $this->hasMany(AuthorizationPermission::class, 'auth_id', 'id');
    }

    /**
    * Get permissions specified for user only
    */
    public function permissions()
    {
        return $this->morphMany(Permission::class, 'permissionable');
    }

    /**
     * Get all departments ids
     */
    public static function departmentIDs($user)
    {
        return $user->employeeObject->directDepartment->childsId($user->employeeObject->authorizedDirectDepartmentsIds());
    }
    
    // Attributes ..

    /**
     * get different between from & to
     */
    public function getDifferentBetweenFromToDatesInDaysAttribute()
    {
        $to   = Carbon::createFromFormat('Y-m-d H:s:i', $this->to_date);
        $from = Carbon::createFromFormat('Y-m-d H:s:i', $this->from_date);
        return $to->diffInDays($from) + 1;
    }

    /**
     * get the status of authorization
     */
    public function getAuthorizationStatusAttribute()
    {
        switch($this->auth_status) {

            case 0:
                return 'جديد';
            break;
            
            case 1:
                return 'ساري';
            break;

            case 2:
            case 3:
                return 'ملغي';
            break;

            case 4:
                return 'انتهى';
            break;

            default:
                return '';

        }
    }

}
