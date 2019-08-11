<?php

namespace Modules\DepartmentServices\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\DepartmentServices\Entities\Attendance\MonthAbsence;
use Modules\DepartmentServices\Entities\Attendance\SalaryDiscountRequest;
use App\Http\Controllers\UserBaseController;
use Modules\Core\Entities\Core\Employee;
use Auth;
use Modules\DepartmentServices\Entities\Attendance\SalaryDiscountRequestEmployee;

use Carbon\Carbon;
use DB;
use Validator;
use Modules\Auth\Entities\Core\User;

class SalaryDiscountRequestsController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

     public function depts()
     {
       $requests = SalaryDiscountRequest::authorizedRequests()->paginate();

       return view('departmentservices::attendance.salary-discount-requests.depts')
                  ->with('requests', $requests);

     }
    public function index(Request $request)
    {
        $idFilter = count(explode("/", $request->request_number)) > 1 ? explode("/", $request->request_number)[1] : null;
        $employeeId = null;

        if (isset($request->user_id)) {

            $employeeId = User::find($request->user_id)->employeeObject->employee_id;

        }


        $requests = SalaryDiscountRequest::authorizedRequests()
                                         ->where(SalaryDiscountRequest::table().'.is_closed', '=', ($request->has('is_closed') ? $request->is_closed : 0) )
                                         ->when($idFilter, function($query) use ($idFilter) {

                                             return $query->where(SalaryDiscountRequest::table().'.id', '=', $idFilter);
                                             
                                         })
                                         ->when($employeeId, function($query) use ($employeeId) {

                                            return $query->join(SalaryDiscountRequestEmployee::table(), SalaryDiscountRequest::table().'.id', '=', SalaryDiscountRequestEmployee::table().'.request_id' )
                                                        ->where(SalaryDiscountRequestEmployee::table().'.employee_id', '=', $employeeId);
                                            
                                        })
                                        ->select(SalaryDiscountRequest::table().'.*')
                                         ->orderBy(SalaryDiscountRequest::table().'.created_at', 'DESC')
                                         ->paginate();

        $requests->appends($request->all());

        if ($this->isApiCall) {
            $data = [
                'requests'  => $requests
            ];

            return response()->json($data);
        }

        return view('departmentservices::attendance.salary-discount-requests.index')
                   ->with('requests', $requests)
                   ->with('userId', $request->user_id);
    }

    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $discountRequest = new SalaryDiscountRequest;

        $months = [];

        foreach (range(1,12) as $month) {
            $months[] = sprintf("%02d", $month);
        }

        $months = array_combine($months, $months);
        $years =  array_combine(range(1439, 1450),range(1439, 1450));
        $monthFilter = $request->year. '-' .$request->month;

        if ($request->year != null && $request->month != null) {

            $employees = MonthAbsence::join(Employee::table(), Employee::table().'.national_id', '=', MonthAbsence::table().'.natio_id')
                                 ->when(($request->year != null && $request->month != null), function($query) use ($request, $monthFilter) {
                                    return $query->where('hijri_month', '=', $monthFilter);
                                 })
                                 ->when(($request->sex != null), function($query) use ($request) {
                                    return $query->where(Employee::table().'.gender', '=', $request->sex);
                                 })
                                 ->where(Employee::table().'.real_dept_code', Auth::user()->employeeObject->real_dept_code)
                                 ->whereNotIn(Employee::table().'.employee_id', SalaryDiscountRequestEmployee::where('month', '=', $monthFilter)->pluck('employee_id')->toArray())
                                 //->where(MonthAbsence::table().'.numof_absentdays', '>', 0)
                                 ->select('emp_name', 'hijri_month', 'overall_late', 'emp_jobid', 'numof_absentdays', 'late_hours', 'late_mins', 'all_absent_dates', 'natio_id')
                                 ->orderBy(MonthAbsence::table().'.numof_absentdays', 'DESC');

            //$employees->appends($request->all());

        } else {
            $employees = SalaryDiscountRequest::where('id', 0);
        }

        if ($request->has('statement')) {

            $employee = $employees->where(Employee::table().'.employee_id', '=', $request->employee_id)->first();

            return view('departmentservices::attendance.salary-discount-requests.single-employee-statement')
                ->with('employee', $employee)
                ->with('months', $months)
                ->with('years', $years)
                ->with('month', $request->month)
                ->with('year', $request->year)
                ->with('sex', $request->sex)
                ->with('discountRequest', $discountRequest);

        } else {

            $employees = $employees->get();

            return view('departmentservices::attendance.salary-discount-requests.create')
                ->with('employees', $employees)
                ->with('months', $months)
                ->with('years', $years)
                ->with('month', $request->month)
                ->with('year', $request->year)
                ->with('sex', $request->sex)
                ->with('discountRequest', $discountRequest);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        $validator->after(function ($validator) use ($request) {

            if (count($request->selected_employees_ids) == 0) {

                $validator->errors()->add('general_error', __('departmentservices::app.at_least_select_one_employee'));

            }

        });

        $validator->validate();

        $discountRequest = null;

        DB::transaction(function () use ($request, &$discountRequest){
            $month = $request->year. '-' .$request->month;

            $discountRequest = new SalaryDiscountRequest;
            $discountRequest->created_by_user_id = Auth::user()->user_id;
            $discountRequest->month = $month;
            $discountRequest->department_id = Auth::user()->employeeObject->real_dept_code;
            $discountRequest->save();

            foreach($request->selected_employees_ids as $id) {
                $discountRequestEmployee = new SalaryDiscountRequestEmployee;
                $discountRequestEmployee->request_id = $discountRequest->id;
                $discountRequestEmployee->employee_id = $id;
                $discountRequestEmployee->month = $month;
                $discountRequestEmployee->save();
            }
        });

        return redirect()->route('salary-discount-requests.show', ['id' => $discountRequest->id]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $canClose = $this->canClose();

        $discountRequest = SalaryDiscountRequest::authorizedRequests(['id' => $id])->first();

        if ($this->isApiCall) {

            $employees = [];
            foreach($discountRequest->employees as $employee) {
                $employees[] = [
                    'employee_id' => $employee->employee_id,
                    'emp_name'    => $employee->monthData()->emp_name,
                    'natio_id'    => $employee->monthData()->natio_id,
                    'numof_absentdays' => $employee->monthData()->numof_absentdays,
                    'absence_days_numbers' => $employee->monthData()->absenceDaysNumbers(),
                    'total_late' => $employee->monthData()->totalLate(),
                ];
            }

            $data = [
                'request'  => $discountRequest,
                'request_number' => $discountRequest->request_number,
                'can_close' => $canClose,
                'employees' => $employees,
                'department' => $discountRequest->department->name,
            ];

            return response()->json($data);
        }

        return view('departmentservices::attendance.salary-discount-requests.show')
               ->with('discountRequest', $discountRequest)
               ->with('canClose', $canClose);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('departmentservices::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $discountRequest = SalaryDiscountRequest::authorizedRequests(['id' => $id])->first();

        if($discountRequest->approved_by_user_id == null && $discountRequest->created_by_user_id == Auth::user()->user_id) {

            $discountRequest->delete();
        }

        return redirect()->route('salary-discount-requests.index');
    }

    public function approve(Request $request, $id)
    {
        $discountRequest = SalaryDiscountRequest::authorizedRequests(['id' => $id])->first();

        if ($discountRequest->hasAbilityToApprove()) {
            $discountRequest->approved_by_user_id = Auth::user()->user_id;
            $discountRequest->approval_date = Carbon::now();
            $discountRequest->save();

            if ($this->isApiCall) {
                return response()->json('success', 200);
            }
        }

        return redirect()->route('salary-discount-requests.show', ['id' => $discountRequest->id]);
    }

    public function close(Request $request, $id)
    {
        if ($this->canClose())
        {
            $discountRequest = SalaryDiscountRequest::authorizedRequests(['id' => $id])->first();
            $discountRequest->is_closed = true;
            $discountRequest->save();

            if ($this->isApiCall) {
                return response()->json('success', 200);
            }
        }


       return redirect()->route('salary-discount-requests.show', ['id' => $discountRequest->id]);
    }

    public function canClose()
    {
        return Auth::user()->isAllAccess() && Auth::user()->isMemberOfGroup('es_management_and_financial_group');
    }
}
