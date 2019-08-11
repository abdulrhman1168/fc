<?php

namespace Modules\DepartmentServices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use App\Classes\Date\CarbonHijri;
use App\Http\Controllers\UserBaseController;
use Modules\MyServices\Entities\HousingAllowanceRequest;

use Validator;

use DB;
use Modules\MyServices\Entities\SchoolYear;
use Modules\Core\Entities\Core\Employee;

use Modules\Auth\Entities\Core\User;

class HrStartWorkRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $currentEmployeeId = $request->user()->employeeObject->employee_id;

        $new_requests = HousingAllowanceRequest::with('applicant.directDepartment','applicant.department', 'schoolYear')
        ->join(Employee::table(), HousingAllowanceRequest::table().'.applicant_user_id', '=',Employee::table().'.employee_id')
        ->join(User::table(), User::table().'.user_idno', '=', Employee::table().'.national_id')
        ->where('hr_start_work_approval',1)   // aproved from general manager
        ->orderBy(HousingAllowanceRequest::table().'.updated_at', 'DESC')
        ->paginate(25);


        $approved_requests = HousingAllowanceRequest::with('applicant.directDepartment','applicant.department', 'schoolYear')
        ->join(Employee::table(), HousingAllowanceRequest::table().'.applicant_user_id', '=',Employee::table().'.employee_id')
        ->join(User::table(), User::table().'.user_idno', '=', Employee::table().'.national_id')
        ->whereIn('hr_start_work_approval',[2,3])  // approved from hr or reject
        ->orderBy(HousingAllowanceRequest::table().'.updated_at', 'DESC')
        ->paginate(25);

        return view('departmentservices::hr-start-work-requests.index')
            ->with('new_requests',$new_requests)
            ->with('approved_requests',$approved_requests)
            ->with('currentEmployeeId',$currentEmployeeId);

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('departmentservices::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

    }

    public function check(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [
        'status' => 'required|in:2,3'  // 2  approve  // 33 reject
      ]);

      $hrequest = HousingAllowanceRequest::where('id', '=' ,$request->id)
                          ->first();


      if ($hrequest->hr_start_work_approval == 1)
      {
        $hrequest->hr_start_work_approval  = $request->status;  //step  1 
        $hrequest->hr_start_work_approval_date = todayHijriDate();
        $hrequest->save();

      }

        return redirect()->route('department-services.hr-start-work-requests.index');

      
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('departmentservices::show');
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
    public function destroy()
    {
    }
}
