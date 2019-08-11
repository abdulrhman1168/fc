<?php

namespace Modules\DepartmentServices\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\UserBaseController;
use Modules\Core\Entities\Core\Employee;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\MyServices\Entities\Permission;
use Modules\DepartmentServices\Entities\Attendance\PermissionChanges;
use Modules\MobileApp\Entities\PushToken;
use App\Classes\PushNotification\PushNotification;

use Lang;

class PermissionsRequestsController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::permissionsForManager($request, auth()->user()->employeeObject);

        if ($this->isApiCall) {
            return response()->json($permissions);
        } else {
            return view('departmentservices::attendance.permissions.index', ['permissions' => $permissions]);
        }
    }

    /**
     * approve the permission
     * @return Response
     */
    public function approve(Request $request, $permission_id)
    {
        $permission = Permission::findByPermissionID($request, auth()->user()->employeeObject, $permission_id);

        if(empty($permission) || $permission == NULL || $permission->status != 0 || !$permission->is_authorized_to_perform_action) {
            return response()->json(['alert_type' => 'danger', 'message' => 'Unauthorized access']);
        }

        $permission->status = 1;
        $permission->action_by_employee_id = auth()->user()->employeeObject->employee_id;
        $permission->save();
        if ($permission->status == 1) {

            $massage = 'تمت موافقة المدير المباشر على '.$permission->type_name;

        }
        $to = PushToken::Where('user_id',$permission->user_id)->get();
        foreach ($to as $rows)
                    {
    
                       PushNotification::PushArray([$rows->token] , $massage);
                     }

        return response()->json(['alert_type' => 'success', 'message' => __('departmentservices::permissions.approved_message'), 'data' => ['id' => $permission->id]]);
    }


    /**
     * reject the permission
     * @return Response
     */
    public function reject(Request $request)
    {
        $validatedData = $request->validate([
            'permission_id'            => 'required|integer',
            'permission_reject_reason' => 'required',
        ]);

        $permission = Permission::findByPermissionID($request, auth()->user()->employeeObject, $request->permission_id);

        if(empty($permission) || $permission == NULL || $permission->status != 0 || !$permission->is_authorized_to_perform_action) {
            return response()->json(['alert_type' => 'danger', 'message' => 'Unauthorized access']);
        }

        $permission->status = 2;
        $permission->reject_reason = $request->permission_reject_reason;
        $permission->action_by_employee_id = auth()->user()->employeeObject->employee_id;
        $permission->save();
        if ($permission->status == 2) {

            $massage = 'نفيدكم انه تم رفض '. $permission->type_name.'  من قبل المدير المباشر ، السبب ' . $permission->reject_reason;
       }
       $to = PushToken::Where('user_id',$permission->user_id)->get();
        foreach ($to as $rows)
                    {
    
                       PushNotification::PushArray([$rows->token] , $massage);
                     }

        return response()->json(['alert_type' => 'success', 'message' => __('departmentservices::permissions.rejected_message'), 'data' => ['id' => $permission->id]]);
    }

    /**
     * count permissions
     * @return Response
     */
    public function total(Request $request)
    {
        return response()->json(['total' => Permission::permissionsForManagerCount($request, auth()->user()->employeeObject)]);
    }

    /**
     * check function for API
     */
    public function check(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'id'            => 'required|integer',
            'status'        => 'required|in:1,2',
            'reject_reason' => 'required_if:status,2',
        ]);

        if ($validation->fails()) {
            return response()->make($validation->errors(), 400);
        }

        $permission = Permission::findByPermissionID($request, auth()->user()->employeeObject, $request->id);

        if(empty($permission) || $permission == NULL || $permission->status != 0 || !$permission->is_authorized_to_perform_action) {
            return response()->json(['alert_type' => 'danger', 'message' => 'Unauthorized access']);
        }

        $permission->status = $request->status;

        if($request->status == 2) {
            $permission->reject_reason = $request->reject_reason;
        }
        $permission->action_by_employee_id = auth()->user()->employeeObject->employee_id;
        $permission->save();

        
        if ($permission->status == 1) {

            $massage = 'تمت موافقة المدير المباشر على '.$permission->type_name;

        }
        if ($permission->status == 2) {

             $massage = 'نفيدكم انه تم رفض '. $permission->type_name.'  من قبل المدير المباشر ، السبب ' . $permission->reject_reason;
        }
        $to = PushToken::Where('user_id',$permission->user_id)->get();
        foreach ($to as $rows)
                    {
    
                       PushNotification::PushArray([$rows->token] , $massage);
                     }
        return response()->json(['alert_type' => 'success', 'message' => 'Update', 'data' => ['id' => $permission->id]]);
    }


    // administrators functions (المتابعة)
    
    /**
     * Display All permissions
     * @return Response
     */
    public function administratorDisplayAllPermissions(Request $request)
    {
        $allPermissions = Permission::join(Employee::table(), Employee::table().'.employee_id', Permission::table().'.employee_number')
                            ->join(HRDepartment::table(), HRDepartment::table().'.id', Permission::table().'.organization_id')
                            ->select(Permission::table().'.id', Permission::table().'.from_date', Permission::table().'.type_name', Permission::table().'.reason', Employee::table().'.arabic_name', Employee::table().'.english_name', Permission::table().'.employee_number', Permission::table().'.status', HRDepartment::table().'.name as department_name')
                            ->orderBy('id', 'asc');
         
        if($request->search) {
            $allPermissions = $allPermissions->where(Permission::table().'.employee_number', 'LIKE', '%'.$request->search.'%')
                                            ->orWhere(Employee::table().'.arabic_name', 'LIKE', '%'.$request->search.'%')
                                            ->orWhere(Employee::table().'.english_name', 'LIKE', '%'.$request->search.'%');
        }

        $allPermissions = $allPermissions->paginate(100);
        
        return view('departmentservices::attendance.permissions.administrator.index', ['permissions' => $allPermissions]);
    }

    /**
     * delete the permission by administrator
     * @return Response
     */
    public function administratorDeletePermission(Request $request)
    {
        $validatedData = $request->validate([
            'permission_id'            => 'required|integer'
        ]);
        
        $permission = Permission::where('id', '=', $request->permission_id)->first();

        if($permission == NULL) {
            return response()->json(['alert_type' => 'danger', 'message' => 'Unauthorized access']);
        }

        // start the transaction
        $transaction = \DB::transaction(function () use ($permission) {
            // logs the chnages
            $permission->previous_id   = $permission->id;
            $permission->action_by     = auth()->user()->employee()->employee_id;
            $permission->action_method = 'delete';
            PermissionChanges::create($permission->toArray());

            // delete the permission
            $permission->delete();
        });

        if(!is_null($transaction))
            return response()->json(['alert_type' => 'danger', 'message' => 'Something went wrong.']);
        else
            return response()->json(['alert_type' => 'success', 'message' => __('departmentservices::permissions.deleted_message'), 'data' => ['id' => $permission->id]]);
    }

    /**
     * edit the permission by administrator
     * @return Response
     */
    public function administratorEditPermission(Request $request)
    {
        $permission = Permission::where('id', $request->id)
                    ->join(Employee::table(), Employee::table().'.employee_id', Permission::table().'.employee_number')
                    ->select(Permission::table().'.*', Employee::table().'.arabic_name', Employee::table().'.english_name')
                    ->first();
        
        if($permission == NULL) {
            return back();
        }

        $permission->employee_name = (Lang::Locale() == 'ar' ? $permission->arabic_name : $permission->english_name);
        $permission->permission_date = $permission->from_date->format('Y-m-d');
        $permission_type_name = [
            901 => __('myservices::permissions.permission_comming'),
            900 => __('myservices::permissions.permission_back'),
        ];
        $permission_status = [
            0 => 'جديد',
            1 => 'موافق عليه',
            2 => 'مرفوض',
        ];
        $permission->permission_reason = $permission->reason;

        return view('departmentservices::attendance.permissions.administrator.edit', compact('permission', 'permission_type_name', 'permission_status'));
    }
    
    /**
     * update the permission by administrator
     * @return Response
     */
    public function administratorUpdatePermission(Request $request)
    {
        $validator = $request->validate([
            'permission_date' => 'required|date_format:Y-m-d',
            'permission_type' => 'required|in:900,901',
            'permission_reason' => 'required',
            'permission_status' => 'required|in:0,1,2',
            'reject_reason' => 'required_if:permission_status,==,2',
        ]);

        $permission = Permission::where('id', $request->id)->first();
        
        if($permission == NULL) {
            return back();
        }

        $permissionExist = Permission::where([
            ['id', '!=', $request->id],
            ['from_date', $request->permission_date .' 00:00:00']
        ])->count();

        if($permissionExist != 0) {
            session()->flash('error', 'يوجد إستئذان بنفس التاريخ');
            return back();
        }

        $permission_type_name = [
            901 => __('myservices::permissions.permission_comming'),
            900 => __('myservices::permissions.permission_back'),
        ];

        // start the transaction
        $transaction = \DB::transaction(function () use ($permission, $request, $permission_type_name) {
            // logs the chnages
            $permission->previous_id   = $permission->id;
            $permission->action_by     = auth()->user()->employee()->employee_id;
            $permission->action_method = 'update';
            PermissionChanges::create($permission->toArray());
            unset($permission->previous_id, $permission->action_by, $permission->action_method);
                            
            // update the permission
            $permission->from_date     = $permission->to_date = $request->permission_date;
            $permission->type_id       = $request->permission_type;
            $permission->type_name     = $permission_type_name[$request->permission_type];
            $permission->reason        = $request->permission_reason;
            $permission->status        = $request->permission_status;
            $permission->reject_reason = $request->permission_status == 2 ? $request->reject_reason : NULL;
            $permission->save();
        });
        
        if(!is_null($transaction))
            session()->flash('error', 'حدث خطأ');
        else
            session()->flash('success', 'تم التحديث');
        
        return redirect()->route('permissions.administrator.display-all-permissions');
    }
    

    /**
     * Display form for adding New permission
     * @return Response
     */
    public function administratorAddPermission(Request $request)
    {
        $permission_type_name = [
            901 => __('myservices::permissions.permission_comming'),
            900 => __('myservices::permissions.permission_back'),
        ];
        $permission_status = [
            0 => 'جديد',
            1 => 'موافق عليه',
            2 => 'مرفوض',
        ];

        return view('departmentservices::attendance.permissions.administrator.add', compact('permission_type_name', 'permission_status'));
    }

    /**
     * store the permission by administrator
     * @return Response
     */
    public function administratorStorePermission(Request $request)
    {
        $validator = $request->validate([
            'employee_number' => 'required|integer|',
            'permission_date' => 'required|date_format:Y-m-d',
            'permission_type' => 'required|in:900,901',
            'permission_reason' => 'required',
            'permission_status' => 'required|in:0,1,2',
            'reject_reason' => 'required_if:permission_status,==,2',
        ]);

        $permissionExist = Permission::where([
            ['employee_number', '=', $request->employee_number],
            ['from_date', $request->permission_date .' 00:00:00']
        ])->count();

        if($permissionExist != 0) {
            session()->flash('error', 'يوجد إستئذان بنفس التاريخ');
            return back()->withInputs($request->all());
        }

        $permission_type_name = [
            901 => __('myservices::permissions.permission_comming'),
            900 => __('myservices::permissions.permission_back'),
        ];

        // get organization_id & direct_manager_id
        $employeeData      = Employee::where('employee_id', $request->employee_number)->first();
        $directManagerData = HRDepartment::find($employeeData->dept_code);
        $isDirectManager   = false;

        if ($directManagerData == null) {
            session()->flash('error', __('myservices::permissions.some_bug_occurs'));
            return back()->withInputs($request->all());
        }

        if($directManagerData->direct_manager_f_id == null || is_null($directManagerData->direct_manager_f_id)) {
            $directManagerData->direct_manager_f_id = $directManagerData->direct_manager_m_id;
        }

        $direct_manager_id = $employeeData->gender == 1 ? $directManagerData->direct_manager_m_id : $directManagerData->direct_manager_f_id;

        if ($request->employee_number == $direct_manager_id) {
            $isDirectManager = true;

            if(!$directManagerData->is_excluded) {
                $directManagerData = HRDepartment::find($directManagerData->parent_id);

                if ($directManagerData == null) {
                    session()->flash('error', __('myservices::permissions.some_bug_occurs'));
                    return back()->withInputs($request->all());
                }
    
                if($directManagerData->direct_manager_f_id == null || is_null($directManagerData->direct_manager_f_id)) {
                    $directManagerData->direct_manager_f_id = $directManagerData->direct_manager_m_id;
                }
    
                $direct_manager_id = $employeeData->gender == 1 ? $directManagerData->direct_manager_m_id : $directManagerData->direct_manager_f_id;
            }

        }

        if ($direct_manager_id == null) {
            session()->flash('error', __('myservices::permissions.some_bug_occurs'));
            return back()->withInputs($request->all());
        }

        // add organization_id in request 
        $request->merge([
            'organization_id' => $employeeData->dept_code,
            'p_dept_code'     => $employeeData->real_dept_code,
            'direct_manager_id' => $direct_manager_id,
        ]);

        // start the transaction
        $transaction = \DB::transaction(function () use ($request, $permission_type_name, $isDirectManager) {
            // add the permission
            $permission                  = new Permission();
            $permission->employee_number = $request->employee_number;
            $permission->organization_id = $request->organization_id;
            $permission->direct_manager_id = $request->direct_manager_id;
            $permission->p_dept_code     = $request->p_dept_code;
            $permission->from_date       = $permission->to_date = $request->permission_date;
            $permission->type_id         = $request->permission_type;
            $permission->type_name       = $permission_type_name[$request->permission_type];
            $permission->reason          = $request->permission_reason;
            $permission->status          = $request->permission_status;
            $permission->reject_reason   = $request->permission_status == 2 ? $request->reject_reason : NULL;
            $permission->request_source  = 'WEB';
            $permission->is_direct_manager = $isDirectManager;
            $permission->save();

            // logs the chnages
            $permission->previous_id   = $permission->id;
            $permission->action_by     = auth()->user()->employee()->employee_id;
            $permission->action_method = 'add';
            PermissionChanges::create($permission->toArray());
        });
        
        if(!is_null($transaction))
            session()->flash('error', 'حدث خطأ');
        else
            session()->flash('success', 'تم الاضافه');
        
        return redirect()->route('permissions.administrator.display-all-permissions');
    }


    // Ajax functions 
    public function administratorEmployeeInfo(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'employee_number' => 'required|integer'
        ]);

        if ($validation->fails()) {
            return response()->make($validation->errors(), 400);
        }

        $employeeData = Employee::where('employee_id', $request->employee_number)->first();

        if($employeeData == NULL) {
            return response()->json('Employee Not found', 400);
        }

        return response()->json($employeeData->arabic_name, 200);
    }

    public function administratorValidatePrmissionDate(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'employee_number' => 'required|integer',
            'permission_date' => 'required|date_format:Y-m-d',
        ]);

        if ($validation->fails()) {
            return response()->make($validation->errors(), 400);
        }

        $employeeData = Employee::where('employee_id', $request->employee_number)->first();

        if($employeeData == NULL) {
            return response()->json('Employee Not found', 400);
        }

        $permissionExist = Permission::where([
            ['employee_number', $request->employee_number],
            ['from_date', $request->permission_date .' 00:00:00']
        ])->count();

        if($permissionExist > 0) {
            return response()->json('Permission exisit', 400);
        }

        return response()->json(200);
    }
    
}
