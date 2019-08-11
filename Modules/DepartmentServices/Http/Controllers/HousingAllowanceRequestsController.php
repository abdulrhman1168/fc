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
use Modules\Housing\Entities\Housing;
use Modules\Auth\Entities\Core\User;

class HousingAllowanceRequestsController extends UserBaseController
{


     /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
    
        $currentEmployeeId = $request->user()->employeeObject->employee_id;
        $isArchived = ($request->is_archived != null && ( intval($request->is_archived) == 3 || $request->is_archived == 1)) ? true : null;
        $requests = HousingAllowanceRequest::authorizedRequests($request)
                                            ->when($request->id, function($query) use ($request) {
                                              $query->where('id', '=', $request->id);
                                            })
                                            ->when($isArchived, function($query) use ($request, $isArchived) {
                                              $query->where('is_archived', '=', ($request->is_archived == 3 ? 0 : $request->is_archived));
                                            })
                                            ->when($request->applicant_user_id, function($query) use ($request) {
                                              $query->where('applicant_user_id', '=', $request->applicant_user_id);
                                            })
                                            ->orderBy('current_step', 'ASC')
                                            ->paginate(40);

        $filteredRequests = $requests;

        // foreach($requests as $request) {
        //   if ($currentEmployeeId == $request->step_1_approval_user_id && $request->status == 1) {
        //     $filteredRequests[] = $request;
        //   } else if ($currentEmployeeId == $request->step_2_approval_user_id && $request->status == 2) {
        //     $filteredRequests[] = $request;
        //   }
        // }

        if ($this->isApiCall) {

          $data = [
              'requests' => $filteredRequests
          ];

        return response()->json($data);

        } else {


          return view('departmentservices::housing-allowance-requests.index')
                  ->with('requests', $filteredRequests->appends($request->all()))
                  ->with('isSalaryApprove', HousingAllowanceRequest::isUserSalaryApproveAbility($request->user()))
                  ->with('currentEmployeeId', $currentEmployeeId);

        }
    }

    public function all(Request $request) 
    {
      $schoolYears = SchoolYear::pluck('name', 'id')->toArray();
      $statuses = HousingAllowanceRequest::statueses();
      $steps = HousingAllowanceRequest::steps();
      $requests = HousingAllowanceRequest::with('applicant.directDepartment','applicant.department', 'schoolYear')
                                         ->join(Employee::table(), HousingAllowanceRequest::table().'.applicant_user_id', '=',Employee::table().'.employee_id')
                                         ->join(User::table(), User::table().'.user_idno', '=', Employee::table().'.national_id')
                                         ->when($request->status, function($query) use ($request) {
                                           $query->where('status', '=', $request->status);
                                         })
                                         ->when($request->current_step, function($query) use ($request) {
                                          $query->where('current_step', '=', ($request->current_step -1));
                                         })
                                         ->when($request->school_year_id, function($query) use ($request) {
                                          $query->where('school_year_id', '=', $request->school_year_id);
                                         })
                                         ->when($request->id, function($query) use ($request) {
                                          $query->where('id', '=', $request->id);
                                         })
                                         ->when($request->applicant_user_id, function($query) use ($request) {
                                          $query->where('applicant_user_id', '=', $request->applicant_user_id);
                                         })
                                         ->when($request->user_name, function($query) use ($request) {
                                          $query->where(User::table().'.user_name', 'LIKE', '%'.$request->user_name.'%');
                                         })
                                         ->orderBy(HousingAllowanceRequest::table().'.updated_at', 'DESC')
                                         ->paginate(25);

      if ($this->isApiCall) {
        
        $data = [
            'requests' => $requests,
            'schoolYears' => $schoolYears,
            'statuses' => $statuses,
            'steps' => $steps
        ];

      return response()->json($data);

      } else {

        $requests->appends($request->all());

        return view('departmentservices::housing-allowance-requests.all')
                ->with('requests', $requests)
                ->with('schoolYears', $schoolYears)
                ->with('statuses', $statuses)
                ->with('steps', $steps);

      }
    }


    public function allShow(Request $request, $id)
    {
      $request = HousingAllowanceRequest::find($id); 

      if ($this->isApiCall) {

        $data = [
            'request' => $request
        ];

      return response()->json($data);

      } else {

        return view('departmentservices::housing-allowance-requests.all-show')
                ->with('request', $request);

      }
    }

    public function show(Request $request, $id)
    {
      $currentEmployeeId = $request->user()->employeeObject->employee_id;
      $hrequest = HousingAllowanceRequest::authorizedRequests($request)  
                    ->where('id', '=', $id)
                    ->first();

      if ($request->print == "yes") {
        return view('departmentservices::housing-allowance-requests.show-print')
                ->with('request', $hrequest)
                ->with('currentEmployeeId', $currentEmployeeId);
      } else {

        return view('departmentservices::housing-allowance-requests.show')
               ->withRequest($hrequest)
               ->with('currentEmployeeId', $currentEmployeeId);
      }
    }

    public function check(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'status' => 'required|in:2,4'
      ]);

      
      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $hrequest = HousingAllowanceRequest::authorizedRequests($request)
                          ->where('id', '=' ,$id)
                          ->first();

      if ($hrequest->step_1_approval_user_id == $request->user()->employeeObject->employee_id && $hrequest->status == 1)
      {
        $hrequest->status = $request->status;
        $hrequest->step_1_approval_date = todayHijriDate();
        $hrequest->current_step = 1;
        $hrequest->save();

      }

      // Validation
      if ($this->isApiCall) {

        return response()->json($request, 201);

      } else {

        return redirect()->route('department-services.housing-allowance-requests.index');

      }
    }

    public function confirm(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'status' => 'required|in:3,5'
      ]);

      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $hrequest = HousingAllowanceRequest::authorizedRequests($request)
                          ->where('id', '=' ,$id)
                          ->first();
      
      if ($hrequest->step_2_approval_user_id == $request->user()->employeeObject->employee_id && $hrequest->status == 2)
      {
          $aplicant_national_id = Employee::where('employee_id',$hrequest->applicant_user_id)->first()->national_id;
          $user_id = User::where('user_idno',$aplicant_national_id)->first()->user_id;
          $housing_approved_before = Housing::where('h_userid',$user_id)->where('status',11)->count();

          $hrequest->status = $request->status;
          $hrequest->step_2_approval_date = todayHijriDate();
          if($housing_approved_before > 0)
          {
            $hrequest->current_step = 0;  // step 0 to disable houseing steps
          }
          else
          {
            $hrequest->current_step = 2;  
          } 
          if($request->status == 3)
          {
            $hrequest->hr_start_work_approval  = 1;  //step  1 
            $hrequest->hr_start_work_approval_date = todayHijriDate();
          }
          $hrequest->save();
       
      }
      // Validation
      if ($this->isApiCall) {
        
        return response()->json($request, 201);

      } else {

        return redirect()->route('department-services.housing-allowance-requests.index');

      }
    }

    public function step4(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'step_4_contract_start_date' => 'required',
        'is_get_allowance_prev' => 'in:0,1'
      ]);

      
      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $hrequest = HousingAllowanceRequest::authorizedRequests($request)
                          ->where('id', '=' ,$id)
                          ->first();

      $hrequest->step_3_approval_user_id = $request->user()->employeeObject->employee_id;
      $hrequest->step_3_approval_date = todayHijriDate();
      $hrequest->current_step = 3;
      $hrequest->step_4_contract_start_date = $request->step_4_contract_start_date;
      $hrequest->step_4_is_get_allowance_prev = $request->step_4_is_get_allowance_prev;
      $hrequest->save();

      // Validation
      if ($this->isApiCall) {

        return response()->json($request, 201);

      } else {

        return redirect()->route('department-services.housing-allowance-requests.index');

      }
    }

    public function step5(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'step_5_companions_no' => 'required',
        'step_5_husband_wife_name' => 'required',
        'step_5_husband_national_id' => 'required',
        'step_5_last_recruitment_date' => 'required',
        'step_5_is_get_trav_for_family' => 'in:0,1',
        'step_5_is_recruitment_before' => 'in:0,1',
      ]);

      
      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $hrequest = HousingAllowanceRequest::authorizedRequests($request)
                          ->where('id', '=' ,$id)
                          ->first();

      $hrequest->step_4_approval_user_id = $request->user()->employeeObject->employee_id;
      $hrequest->step_4_approval_date = todayHijriDate();
      $hrequest->current_step = 4;
      $hrequest->step_5_companions_no = $request->step_5_companions_no;
      $hrequest->step_5_husband_wife_name = $request->step_5_husband_wife_name;
      $hrequest->step_5_husband_national_id = $request->step_5_husband_national_id;
      $hrequest->step_5_last_recruitment_date = $request->step_5_last_recruitment_date;
      $hrequest->step_5_is_get_trav_for_family = $request->step_5_is_get_trav_for_family;
      $hrequest->step_5_is_recruitment_before = $request->step_5_is_recruitment_before;
      $hrequest->save();

      // Validation
      if ($this->isApiCall) {

        return response()->json($request, 201);

      } else {

        return redirect()->route('department-services.housing-allowance-requests.index');

      }
    }

    public function step6(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'step_6_housing_allow_status' => 'required|in:1,2'
      ]);

      
      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $hrequest = HousingAllowanceRequest::authorizedRequests($request)
                          ->where('id', '=' ,$id)
                          ->first();

      $hrequest->step_5_approval_user_id = $request->user()->employeeObject->employee_id;
      $hrequest->step_5_approval_date = todayHijriDate();
      $hrequest->current_step = 5;
      $hrequest->step_6_housing_allow_status = $request->step_6_housing_allow_status;
      $hrequest->save();

      // Validation
      if ($this->isApiCall) {

        return response()->json($request, 201);

      } else {

        return redirect()->route('department-services.housing-allowance-requests.index');

      }
    }

    public function step7(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'approved' => 'required|in:1'
      ]);

      
      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $hrequest = HousingAllowanceRequest::authorizedRequests($request)
                          ->where('id', '=' ,$id)
                          ->first();

      if ($hrequest->isSalaryApproveAbility($request->user())) {

        $hrequest->step_6_approval_user_id = $request->user()->employeeObject->employee_id;
        $hrequest->step_6_approval_date = todayHijriDate();
        $hrequest->current_step = 6;
        $hrequest->status = 6;
        $hrequest->save();
      }
      
      // Validation
      if ($this->isApiCall) {

        return response()->json($request, 201);

      } else {

        return redirect()->route('department-services.housing-allowance-requests.index');

      }
    }

    public function archive(Request $request, $id)
    {
      $hrequest = HousingAllowanceRequest::authorizedRequests($request)
                          ->where('id', '=' ,$id)
                          ->first();

      $hrequest->is_archived = true;
      $hrequest->save();

      if ($this->isApiCall) {

        return response()->json($request, 201);

      } else {

        return redirect()->route('department-services.housing-allowance-requests.index');

      }

    }


    public function stepBack(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
          'step_back' => 'required|in:6,7'
        ]);

        
        // Validation
        if ($this->isApiCall) {

          if ($validator->fails()) {

              return response()->json($validator->errors(), 422);

          }
        } else {

            $validator->validate();
        }

        $hrequest = HousingAllowanceRequest::authorizedRequests($request)
                            ->where('id', '=' ,$id)
                            ->first();
        if($request->step_back == 6)
        {
          $hrequest->step_5_approval_user_id = null;
          $hrequest->step_5_approval_date = null;
          $hrequest->step_6_approval_user_id = null;
          $hrequest->step_6_approval_date = null;
          $hrequest->current_step = 4; 
          $hrequest->status = 3;
          $hrequest->step_6_housing_allow_status = null;
        }
        elseif($request->step_back == 7)
        {
          $hrequest->step_6_approval_user_id = null;
          $hrequest->step_6_approval_date = null;
          $hrequest->current_step = 5;
          $hrequest->status = 3;
        }
        $hrequest->save();



        // Validation
        if ($this->isApiCall) {

          return response()->json($request, 201);

        } else {

          return redirect()->route('department-services.housing-allowance-requests.index');

        }
    
    }
}
