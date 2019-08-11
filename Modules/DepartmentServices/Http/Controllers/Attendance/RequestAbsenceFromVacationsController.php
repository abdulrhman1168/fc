<?php

namespace Modules\DepartmentServices\Http\Controllers\Attendance;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Validator;

// Entities
use Modules\Core\Entities\Core\HRDepartment;
use Modules\Core\Entities\Core\Employee;
use Modules\MyServices\Entities\Attendance\RequestAbsenceVacations;

class RequestAbsenceFromVacationsController extends UserBaseController
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $requestAbsenceVacations = RequestAbsenceVacations::departmentRequests(auth()->user()->employeeObject->authorizedDepartmentsIds())->get();

        if ($this->isApiCall) {
            $data = [
                'statueses' => RequestAbsenceVacations::statueses(),
                'requests'  => $requestAbsenceVacations
            ];

            return response()->json($data);
        }
        
        return view('departmentservices::attendance.request-absence-from-vacations.index', compact('requestAbsenceVacations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        return view('departmentservices::attendance.request-absence-from-vacations.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('departmentservices::attendance.request-absence-from-vacations.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('departmentservices::attendance.request-absence-from-vacations.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
                            'status' => 'required|in:2,3,4,5'
                        ]);
        
        // Validation
        if ($this->isApiCall && $validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        else {
            $validator->validate();
        }

        $vacation = RequestAbsenceVacations::departmentRequests(auth()->user()->employeeObject->authorizedDepartmentsIds())->findOrFail($id);
        
        if(in_array($request->status, [2,4]) && $vacation->canCheckRequest) {
            $vacation->status = $request->status;
            $vacation->checker_employee_id = auth()->user()->employeeObject->employee_id;
            $vacation->check_date = date('Y-m-d H:i:s');

            if(@$request->user()->employeeObject->directDepartment->parent->is_excluded == 1) {
                $vacation->status = 3;
                $vacation->confirmer_employee_id = $request->user()->employeeObject->employee_id;
                $vacation->confirm_date = date('Y-m-d H:i:s');
                RequestAbsenceVacations::insertInErp($vacation);
            }
            
            $vacation->save();
        }
        
        else if(in_array($request->status, [3,5]) && $vacation->canConfirmRequest) {

            \DB::transaction(function () use ($request, &$vacation){
                $vacation->status = $request->status;
                $vacation->confirmer_employee_id = $request->user()->employeeObject->employee_id;
                $vacation->confirm_date = date('Y-m-d H:i:s');
                $vacation->save();
      
                if ($vacation->status == 3) {
                    RequestAbsenceVacations::insertInErp($vacation);
                }
            });

        }

        if ($this->isApiCall) {
            return response()->json($vacation, 201);
        }
        else {
            return redirect()->route('department-services.request-absence-from-vacations.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, $id)
    {

    }
}
