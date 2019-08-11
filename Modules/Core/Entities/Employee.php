<?php
namespace Modules\Core\Entities\Core;

use Illuminate\Database\Eloquent\Model;

use Modules\Core\Entities\Core\HRDepartment;
use App;
use Modules\Auth\Entities\Core\User;
use Modules\DepartmentServices\Entities\Authorization\AuthorizationEmployee;
use Modules\Core\Entities\Core\App as CoreApp;
use Modules\MyServices\Entities\AirportTransfer\AirportTransferOrders;
use Modules\ClearanceForm\Entities\ClearanceForm;
use Modules\MyServices\Entities\Attendance\RequestAbsenceVacations;

class Employee extends Model
{
    use \Modules\Core\Traits\SharedModel;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'mu_users'; // hr_employees has been replaced with ERP.INT_GET_ALL_EMPLOYEE_INFO because it have some issues like it takes 40s in join!!


    public function parent()
    {
        return $this->belongsTo(HRDepartment::class, 'parent_id');
    }

    public function department()
    {
        return $this->belongsTo(HRDepartment::class, 'real_dept_code');
    }

    public function directDepartment()
    {
        return $this->belongsTo(HRDepartment::class, 'dept_code');
    }

    public function departmentsData($maxLevel = 0)
    {
        $departmentsData     = [];
        $currentDepartmentID = 0;
        
        $currentDepartment = $this->directDepartment()->first();
        $departmentsData['level'. $currentDepartmentID] = $currentDepartment;

        while($currentDepartment = optional($currentDepartment)->parent()->first()) {
            $currentDepartmentID++;
            $departmentsData['level'. $currentDepartmentID] = $currentDepartment;

            if($maxLevel != 0 && $currentDepartmentID == ($maxLevel-1)) {
                break;
            }
        }

        return $departmentsData;
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'national_id', 'user_idno');
    }

    public function departmentsManage()
    {
        return HRDepartment::where(function ($query) {
            $query->where('direct_manager_m_id', $this->employee_id)
                 ->orWhere('direct_manager_f_id', $this->employee_id);
        });
    }

    public function sectionsManage()
    {
        return $this->departmentsManage()->where('type', 7);
    }

    public function collagesManage()
    {
        return $this->departmentsManage()->where('type', 2);
    }

    public function sectionsManageCollages()
    {
        $collagesIds = $this->sectionsManage()->lists('parent_id');

        return HRDepartment::whereIn('id', $collagesIds);
    }

    public function getDirectManagerEmployeeId()
    {
        $employeeId = null;

        if ($this->gender == 1) {

            $employeeId = $this->directDepartment->direct_manager_m_id;

        } else if ($this->gender == 2) {
            $employeeId = $this->directDepartment->direct_manager_f_id;

            if ($employeeId == null) {
                $employeeId = $this->directDepartment->direct_manager_m_id;
            }
        }

        return $employeeId;
    }

    public function getParentManagerEmployeeId()
    {
        $employeeId = null;

        if ($this->gender == 1) {

            $employeeId = $this->department->direct_manager_m_id;

        } else if ($this->gender == 2) {
            
            $employeeId = $this->department->direct_manager_f_id;

            if ($employeeId == null) {
                $employeeId = $this->department->direct_manager_m_id;
            }
        }

        return $employeeId;
    }

    public function sameDirectDeptEmployees()
    {
        return self::where('dept_code', '=', $this->dept_code)
                   ->WhereNotIn('employee_id', [$this->employee_id]);
    }
    
    public function authorizationEmployees()
    {
        return $this->hasMany(AuthorizationEmployee::class, 'employee_id', 'employee_id');
    }

    public function authorizedDepartments()
    {
        return $this->hasMany(AuthorizationEmployee::class, 'auth_employee_id', 'employee_id');
    }

    /**
     * get direct departments ids
     */
    public function authorizedDirectDepartmentsIds()
    {
        return $this->departmentsManage()->pluck('id')->toArray();
    }
    /**
     * get all departments ids when he is the direct manager or has authorization
     */
    public function authorizedDepartmentsIds()
    {
        $departmentsIds = $this->authorizedDirectDepartmentsIds();

        list($resourceName) = explode('@', \Route::currentRouteAction());

        $currentAppId = CoreApp::where('resource_name', 'like', $resourceName . '%')->pluck('id')->toArray();
        if(!empty($currentAppId)) {
            $authorizedDepartments = AuthorizationEmployee::where([
                ['auth_employee_id', $this->employee_id],
                ['auth_status', 1]
            ])
            ->with('permissions')
            ->get();
    
            foreach($authorizedDepartments as $department) {
                foreach($department->permissions as $permission) {
                    if(in_array($permission->app_id, $currentAppId)) {
                        $departmentsIds[] = $department->organization_id;
                    }
                }
            }
        }

        $departmentsIds = array_unique($departmentsIds);
        return $departmentsIds;
    }

    /**
     * get employee data by employee id
     */
    public static function getEmployeeDataByEmployeeId($employeeId)
    {
        return self::where('employee_id', $employeeId)->first();
    }

    /**
     * get manager of
     */
    public function getManagerOf($employeeId, $currentPermission, $managerType = 'direct')
    {
        $employeeData    = optional(self::getEmployeeDataByEmployeeId($employeeId));
        $currentEmployee = null;
        $delegation      = stripos( optional($currentPermission)->permissionable_type, 'AuthorizationEmployee' ) !== false;

        if ($delegation) {
            $currentEmployee = optional(self::getEmployeeDataByEmployeeId($currentPermission->permissionable->employee_id));
        } else {
            $currentEmployee = $this;
        }

        if( $managerType == 'direct' && $currentEmployee->employee_id == $employeeData->getDirectManagerEmployeeId() ) {
            return true;
        }
        else if( $managerType == 'parent' && $currentEmployee->employee_id == $employeeData->getParentManagerEmployeeId() ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * check if the auth employee is direct manager of given employee id
     */
    public function isDirectManagerOf($employeeId, $currentPermission)
    {
        return $this->getManagerOf($employeeId, $currentPermission, 'direct');
    }

    /**
     * check if the auth employee is parent manager of given employee id
     */
    public function isParentManagerOf($employeeId, $currentPermission)
    {
        return $this->getManagerOf($employeeId, $currentPermission, 'parent');
    }

    public function name()
    {
        if (App::getLocale() == "ar") {

            return $this->arabic_name;

        } else {

            return $this->english_name;
        }
    }

    public function getNameAttribute()
    {
        if (App::getLocale() == "ar") {

            return $this->arabic_name;

        } else {

            return $this->english_name;
        }
    }

    public function getJobInfoAttribute()
    {
        return $this->job_desc . ' - ' . $this->scale_desc;
    }
    
    public function airportTransfer()
    {
        return $this->hasMany(AirportTransferOrders::class, 'employee_id', 'employee_id');
    }

    public function clearanceForm()
    {
        return $this->hasMany(ClearanceForm::class, 'employee_id', 'employee_id');
    }

    public function requestAbsenceVacations()
    {
        return $this->hasMany(RequestAbsenceVacations::class, 'employee_id', 'employee_id');
    }

    /**
     * Get parent id of employee based on dept_code of direct department of employee
     */
    public function getDeptParentIDAttribute()
    {
        return (int) $this->directDepartment->parent_id;
    }

    /**
     * Get employee id of parent employee based on dept_code of direct department of employee
     */
    public function getDeptParentEmployeeIDAttribute()
    {
        if($this->gender == 1 || $this->directDepartment->parent->direct_manager_m_id == NULL) {
            return (int) $this->directDepartment->parent->direct_manager_m_id;
        }
        return (int) $this->directDepartment->parent->direct_manager_f_id;
    }

}
