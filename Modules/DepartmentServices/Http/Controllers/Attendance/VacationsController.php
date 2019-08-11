<?php
namespace Modules\DepartmentServices\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MyServices\Entities\Attendance\Attendance;
use Modules\MyServices\Entities\Attendance\Status;
use Illuminate\Support\Carbon;
use App\Classes\Date\CarbonHijri;
use App\Http\Controllers\UserBaseController;
use Modules\MyServices\Entities\Attendance\Vacation;
use Modules\Core\Entities\Core\Employee;
use Modules\MobileApp\Entities\PushToken;
use App\Classes\PushNotification\PushNotification;

use Validator;

use DB;

class VacationsController extends UserBaseController
{

     /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $currentEmployeeId = $request->user()->employeeObject->employee_id;

        $filteredVacations = Vacation::vacationsForManager($request, auth()->user());

        if ($this->isApiCall) {

          $data = [
              'vacation_types' => Vacation::vacationTypes(),
              'statueses' => Vacation::statueses(),
              'vacations' => $filteredVacations
          ];

        return response()->json($data);

        } else {

          return view('departmentservices::attendance.vacations.index')
                  ->with('vacationTypes', Vacation::vacationTypes())
                  ->with('statueses', Vacation::statueses())
                  ->with('currentEmployeeId', $currentEmployeeId)
                  ->with('vacations', $filteredVacations);

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
         else {
            $validator->validate();
        }
      }

      $vacation = Vacation::findByVacationID($request, auth()->user(), $id);

      if (in_array($vacation->dept_code, $request->user()->employeeObject->authorizedDepartmentsIds()) && $vacation->status == 1)
      {
            $vacation->status = $request->status;
            $vacation->checker_employee_id = $request->user()->employeeObject->employee_id;
            $vacation->check_date = Carbon::now();
            $vacation->save();
            
            //if(@$request->user()->employeeObject->directDepartment->parent->is_excluded == 1) {
            if(@$vacation->employee->directDepartment->parent->is_excluded == 1 && !in_array(@$request->user()->employeeObject->directDepartment->id, [5941])) {
                $request->status = 3;
                Vacation::insertVacation($request, $vacation);
            }
            
            if ($request->status == 2 ) {

              $massageForvacationRequest = 'نفيدك انه تمت الموافقة المبدئية على اجازتك وتم احالة إجازتك ';
              $massageForManager = 'لديك إجازة تنتظر الإعتماد';

              $to = PushToken::leftJoin(Employee::table(), Employee::table().'.user_id', PushToken::table().'.user_id')->Where('employee_id',$vacation->employee_id)->get();
              foreach ($to as $rows)
                          {
          
                             PushNotification::PushArray([$rows->token] , $massageForvacationRequest);

                           }

            $to = PushToken::leftJoin(Employee::table(), Employee::table().'.user_id', PushToken::table().'.user_id')->Where('employee_id',$vacation->confirmer_employee_id)->get();
            foreach ($to as $rows)
                            {
                       
                                PushNotification::PushArray([$rows->token] , $massageForManager);

                            }
                           
            } else if ($request->status == 4 ) {

              $massage = 'نفيدك انه تم رفض اجازتك من قبل المدير المباشر';

              $to = PushToken::leftJoin(Employee::table(), Employee::table().'.user_id', PushToken::table().'.user_id')->Where('employee_id',$vacation->employee_id)->get();
              foreach ($to as $rows)
                          {
          
                             PushNotification::PushArray([$rows->token] , $massage);

                           }

            } else if ($request->status == 3 ) {

              $massage = 'نفيدك انه تم اعتماد اجازتك من قبل المدير المباشر';

              $to = PushToken::leftJoin(Employee::table(), Employee::table().'.user_id', PushToken::table().'.user_id')->Where('employee_id',$vacation->employee_id)->get();
              foreach ($to as $rows)
                          {
          
                             PushNotification::PushArray([$rows->token] , $massage);

                           }

            } 

            
            
            
      }

      // Validation
      if ($this->isApiCall) {

        return response()->json($vacation, 201);

      } else {

        return redirect()->route('department-services.vacations.index');

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

      $vacation = Vacation::findByVacationID($request, auth()->user(), $id);

      if (in_array($vacation->parent_id, $request->user()->employeeObject->authorizedDepartmentsIds()) && $vacation->status == 2)
      {
          Vacation::insertVacation($request, $vacation);
        if ($request->status == 3) {
          $massage = 'نفيدك انه تم اعتماد اجازتك من قبل مسؤول الجهة ';
        } else if ($request->status == 5) {
          $massage = 'نفيدك انه تم رفض اجازتك من قبل مسؤول الجهة ';
        }
          

              $to = PushToken::leftJoin(Employee::table(), Employee::table().'.user_id', PushToken::table().'.user_id')->Where('employee_id',$vacation->employee_id)->get();
              foreach ($to as $rows)
                          {
          
                             PushNotification::PushArray([$rows->token] , $massage);

                           }

      }

      // Validation
      if ($this->isApiCall) {

        return response()->json($vacation, 201);

      } else {

        return redirect()->route('department-services.vacations.index');

      }
    }


    /**
     * Display vacations for faculty member
     * @return Response
     */
    public function facultyMembers(Request $request)
    {
        $currentEmployeeId = $request->user()->employeeObject->employee_id;
        $filteredVacations = Vacation::facultyMembersVacations();

        if ($this->isApiCall) {

          $data = [
              'vacation_types' => Vacation::vacationTypes(),
              'statueses' => Vacation::statueses(),
              'vacations' => $filteredVacations
          ];

        return response()->json($data);

        } else {

          return view('departmentservices::attendance.vacations.faculty-members')
                  ->with('vacationTypes', Vacation::vacationTypes())
                  ->with('statueses', Vacation::statueses())
                  ->with('currentEmployeeId', $currentEmployeeId)
                  ->with('vacations', $filteredVacations);

        }
    }



    public function facultyMembersConfirm(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'status' => 'required|in:9,7'
      ]);

      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $vacation = Vacation::where(Vacation::table().'.id', '=' ,$id)
                          ->first();

      if ($vacation->status == 6)
      {
        DB::transaction(function () use ($request, &$vacation){

          $vacation->status = $request->status;
          //$vacation->confirm_date = Carbon::now();
          $vacation->save();


        });

      }

      // Validation
      if ($this->isApiCall) {

        return response()->json($vacation, 201);

      } else {

        return redirect()->route('department-services.vacations-faculty-members');

      }
    }


    // HR step

    public function hr(Request $request)
    {
        $currentEmployeeId = $request->user()->employeeObject->employee_id;
        $filteredVacations = Vacation::HRVacations();

        if ($this->isApiCall) {

          $data = [
              'vacation_types' => Vacation::vacationTypes(),
              'statueses' => Vacation::statueses(),
              'vacations' => $filteredVacations
          ];

        return response()->json($data);

        } else {

          return view('departmentservices::attendance.vacations.hr')
                  ->with('vacationTypes', Vacation::vacationTypes())
                  ->with('statueses', Vacation::statueses())
                  ->with('currentEmployeeId', $currentEmployeeId)
                  ->with('vacations', $filteredVacations);

        }
    }
    // HR store

    public function hrConfirm(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'status' => 'required|in:3,10'
      ]);

      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $vacation = Vacation::where(Vacation::table().'.id', '=' ,$id)
                          ->first();

      if ($vacation->status == 9)
      {
        DB::transaction(function () use ($request, &$vacation){

          $vacation->status = $request->status;
          $vacation->confirm_date = Carbon::now();
          $vacation->save();

           if ($vacation->status == 3) {
             // Insert in erp
             Vacation::insertInErp($vacation);
           }
        });

      }

      // Validation
      if ($this->isApiCall) {

        return response()->json($vacation, 201);

      } else {

        return redirect()->route('department-services.vacations-hr');

      }
    }

    // relatios employees step

    public function relationsEmployees(Request $request)
    {
        $currentEmployeeId = $request->user()->employeeObject->employee_id;
        $filteredVacations = Vacation::relationsEmployeesVacations();

        if ($this->isApiCall) {

          $data = [
              'vacation_types' => Vacation::vacationTypes(),
              'statueses' => Vacation::statueses(),
              'vacations' => $filteredVacations
          ];

        return response()->json($data);

        } else {

          return view('departmentservices::attendance.vacations.relations-employees')
                  ->with('vacationTypes', Vacation::vacationTypes())
                  ->with('statueses', Vacation::statueses())
                  ->with('currentEmployeeId', $currentEmployeeId)
                  ->with('vacations', $filteredVacations);

        }
    }

    public function relationsEmployeesConfirm(Request $request, $id)
    {

      $validator = Validator::make($request->all(), [
        'visa_status' => 'required|in:1'
      ]);

      // Validation
      if ($this->isApiCall) {

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);

        }
      } else {

          $validator->validate();
      }

      $vacation = Vacation::where(Vacation::table().'.id', '=' ,$id)
                          ->first();

      if ($vacation->status == 3 && $vacation->vacation_code == 16)
      {
        DB::transaction(function () use ($request, &$vacation){

          $vacation->visa_status = $request->visa_status;
          $vacation->visa_confirm_date = Carbon::now();
          $vacation->save();

        });

      }

      // Validation
      if ($this->isApiCall) {

        return response()->json($vacation, 201);

      } else {

        return redirect()->route('department-services.vacations-relations-employees');

      }
    }


}
