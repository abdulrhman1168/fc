<?php

namespace Modules\DepartmentServices\Entities\Attendance;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\Core\Employee;
use Modules\Core\Entities\Core\HRDepartment;

class EmployeesAttendance extends Model
{
    use \Modules\Core\Traits\SharedModel;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'ATT.ERP_V_STATUS_ATTENDANCE';


    protected $dates = ['sign_date'];

    protected $appends = ['is_delayed', 'delay_minutes'];

    /**
     * Get all departments ids
     */
    public static function departmentIDs($user)
    {
        return $user->employeeObject->directDepartment->childsId($user->employeeObject->authorizedDirectDepartmentsIds());
    }

    /**
     * Get all employees attendance with departments & ids
     */
    public static function employeesAttendance($user, $departmentsIDs, $searchParms = [])
    {
        $employeesAttendance = self::join(Employee::table(), Employee::table().'.employee_id', self::table().'.employee_job_no')
                                    ->join(HRDepartment::table(), function ($join) use($departmentsIDs) {
                                        $join->on(HRDepartment::table().'.id', '=', Employee::table().'.dept_code')
                                             ->whereIn(HRDepartment::table().'.id', $departmentsIDs);
                                    })

                                    ->select(
                                        self::table().'.employee_job_no', self::table().'.sign_date', self::table().'.checkin', self::table().'.checkout', self::table().'.status_code', self::table().'.status_name', self::table().'.minin',
                                        Employee::table().'.arabic_name',
                                        HRDepartment::table().'.name as department_name'
                                    );
        
        if(isset($searchParms['department_id']) && !empty($searchParms['department_id'])) {
            $employeesAttendance->whereIn(Employee::table().'.dept_code', $searchParms['department_id']);
        }

        if(isset($searchParms['employee_id']) && !empty($searchParms['employee_id'])) {
            $employeesAttendance = $employeesAttendance->whereIn(self::table().'.employee_job_no', $searchParms['employee_id']);
        }

        if(isset($searchParms['attendance_status']) && !empty($searchParms['attendance_status'])) {
            $employeesAttendance = $employeesAttendance->whereIn(self::table().'.status_code', $searchParms['attendance_status']);
        }

        if(isset($searchParms['start_date']) && isset($searchParms['end_date'])) {
            $employeesAttendance = $employeesAttendance->whereBetween(self::table().'.sign_date', [$searchParms['start_date'], $searchParms['end_date']]);
        }

        
        $employeesAttendance = $employeesAttendance->orderBy(self::table().'.sign_date', 'asc')->paginate(25);

        return $employeesAttendance;
    }

    public function getIsDelayedAttribute()
    {
        return ( $this->status_code != 'X' && $this->minin > 0) ? true : false;
    }

    public function getDelayMinutesAttribute()
    {
        return $this->is_delayed ? $this->minin : 0;
    }
}
