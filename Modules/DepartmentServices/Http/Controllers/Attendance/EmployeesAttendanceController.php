<?php

namespace Modules\DepartmentServices\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\UserBaseController;
use Modules\Core\Entities\Core\Employee;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\MyServices\Entities\Attendance\Status;
use Modules\DepartmentServices\Entities\Attendance\EmployeesAttendance;

class EmployeesAttendanceController extends UserBaseController
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        // filter search action
        $searchParms = [];
        $searchParms['start_date'] = date('Y-m-d');
        $searchParms['end_date'] = date('Y-m-d');

        if($request->input('department_id')) {
            $searchParms['department_id'] = (is_array($request->input('department_id')) ? $request->input('department_id') : [$request->input('department_id')]);
        }
        
        if($request->input('employee_id')) {
            $searchParms['employee_id'] = (is_array($request->input('employee_id')) ? $request->input('employee_id') : [$request->input('employee_id')]);
        }

        if($request->input('attendance_status')) {
            $searchParms['attendance_status'] = (is_array($request->input('attendance_status')) ? $request->input('attendance_status') : [$request->input('attendance_status')]);

        }

        if($request->input('start_date') && (bool)strtotime($request->input('start_date'))) {
            $searchParms['start_date'] = $request->input('start_date');
        }

        if($request->input('end_date') && (bool)strtotime($request->input('end_date'))) {
            $searchParms['end_date'] = $request->input('end_date');
        }
        
        $departmentsIDs      = EmployeesAttendance::departmentIDs($request->user());
        $departmentsData     = HRDepartment::whereIn('id', $departmentsIDs)->orderBy(HRDepartment::table().'.id')->pluck('name', 'id');
        $attendanceStatuses  = Status::orderBy(Status::table().'.code')->pluck('name', 'code');
        $employeesData       = Employee::whereIn('dept_code', $departmentsIDs)->orderBy(Employee::table().'.dept_code')->pluck('arabic_name', 'employee_id');
        $employeesAttendance = EmployeesAttendance::employeesAttendance($request->user(), $departmentsIDs, $searchParms);

        if ($this->isApiCall) {
            return response()->json([
                'departmentsData' => $departmentsData,
                'attendanceStatuses' => $attendanceStatuses,
                'employeesData' => $employeesData,
                'employeesAttendance' => $employeesAttendance,
                
            ]);
        }
        
        return view('departmentservices::attendance.employees.index', ['departmentsData' => $departmentsData, 'attendanceStatuses' => $attendanceStatuses, 'employeesData' => $employeesData, 'employeesAttendance' => $employeesAttendance]);
    }

}
