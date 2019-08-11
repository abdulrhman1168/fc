<?php

namespace Modules\DepartmentServices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\UserBaseController;
use Modules\Core\Entities\Core\App;
use Modules\Core\Entities\Core\Employee;
use Modules\Auth\Entities\Core\User;
use Modules\DepartmentServices\Entities\Authorization\AuthorizationEmployee;
use Modules\DepartmentServices\Entities\Authorization\AuthorizationPermission;
use Modules\Core\Entities\Core\HRDepartment;
use Validator;

class AuthorizationController extends UserBaseController
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $currentAuthorizationEmployees = auth()->user()->employeeObject
                                                ->authorizationEmployees()
                                                ->with('authorizedEmployee')
                                                ->orderBy('id', 'DESC')
                                                ->where('auth_status', 1)
                                                ->get();

        $otherAuthorizationEmployees = auth()->user()->employeeObject
                                                ->authorizationEmployees()
                                                ->with('authorizedEmployee')
                                                ->orderBy('id', 'DESC')
                                                ->where('auth_status', '<>', 1)
                                                ->paginate(25);
                                                
        return view('departmentservices::authorization.index', compact('currentAuthorizationEmployees', 'otherAuthorizationEmployees'));
    }


    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create(Request $request)
    {
        $organizations = HRDepartment::where('direct_manager_m_id', auth()->user()->employeeObject->employee_id)
                                        ->orWhere('direct_manager_f_id', auth()->user()->employeeObject->employee_id)
                                        ->pluck('name', 'id');
        
        $apps = AuthorizationPermission::departmentServicesApps();
        
        $departmentsIDs = AuthorizationEmployee::departmentIDs($request->user());
        $employeesData  = Employee::whereIn('dept_code', $departmentsIDs)->orderBy(Employee::table().'.dept_code')->pluck('arabic_name', 'employee_id')->prepend('', '');

        if ($this->isApiCall) {
            return response()->json(['apps' => $apps, 'organizations' => $organizations, 'employees' => $employeesData], 200);
        }

        return view('departmentservices::authorization.create', compact('organizations', 'apps', 'employeesData'));
    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'organization_id'  => 'required|exists:'. HRDepartment::table() .',id',
            'auth_employee_id' => 'required',
            'from_date'        => 'required|date|after:yesterday',
            'to_date'          => 'required|date|after_or_equal:from_date',
            'powers.*'         => 'required|exists:'. App::table() .',id',
        ]);

        if ($this->isApiCall) {
            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }
        } else {
            $validatedData->validate();
        }
        
        $request->merge([
            'employee_id' => auth()->user()->employeeObject->employee_id,
            'organization_id' => $request->organization_id,
            'auth_status' => 0,
        ]);

        $authEmployeeData = Employee::where('employee_id', $request->auth_employee_id)->first();
        if(is_null($authEmployeeData)) {
            session()->flash('error', 'يرجى اختيار الموظف بشكل صحيح.'); 
            return back()->withInput();     
        }

        // check if the employee is the direct manager for the organization 
        $departmentData   = HRDepartment::findOrFail($request->organization_id);
        if(!in_array($request->employee_id, [$departmentData->direct_manager_m_id, $departmentData->direct_manager_f_id])) {
            session()->flash('error', 'لا يوجد لديك صلاحية على الإدارة المحددة.'); 
            return back()->withInput();   
        }

        // check if the employee belongs to the department 
        // $authEmployeeData = Employee::where('employee_id', $request->auth_employee_id)->first();
        // if($authEmployeeData->dept_code != $request->organization_id && $authEmployeeData->real_dept_code != $request->organization_id) {
        //     session()->flash('error', 'الموظف ليس تابع للإدارة المحددة.'); 
        //     return back()->withInput();   
        // }
        // $departmentsIDs   = AuthorizationEmployee::departmentIDs($request->user());
        // $authEmployeeData = Employee::where('employee_id', $request->auth_employee_id)->first();
        // if(!in_array($authEmployeeData->dept_code, $departmentsIDs)) {
        //     session()->flash('error', 'الموظف ليس تابع للإدارة المحددة.'); 
        //     return back()->withInput();   
        // }

        // check if there is pervious auth
        if(
            auth()->user()->employeeObject->authorizationEmployees()->where([
                ['auth_employee_id', $request->auth_employee_id]
            ])
            ->WhereIn('auth_status', [0, 1])
            ->count() > 0
        )
        {
            session()->flash('error', 'يوجد تفويض سابق لنفس الموظف'); 
            return back()->withInput();
        }

        // get all apps ID
        $appsIds = AuthorizationPermission::departmentServicesApps()->pluck('id')->toArray();
        
        // compare Apps id with data in DB
        $validAppIds = array_intersect($appsIds, empty($request->powers) ? [] : $request->powers);

        // check if the validAppIds is empty
        if(empty($validAppIds)) {
            session()->flash('error', 'يرجى تحديد الصلاحيات'); 
            return back()->withInput();
        }

        $appsData = App::whereIn('id', $validAppIds)
                       ->with('children')
                       ->get();
        

        // start transaction
        \DB::beginTransaction();
        try {
            
            // create New record in authorization employees
            $authorizationEmployeeData = AuthorizationEmployee::create($request->all());

            // insert permissions
            $apps = [];

            // add main menu
            $apps[] = [
                'auth_id' => $authorizationEmployeeData->id,
                'app_id'  => $appsData[0]->parent_id,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ];

            foreach($appsData as $app) {
                $apps[] = [
                    'auth_id' => $authorizationEmployeeData->id,
                    'app_id'  => $app->id,
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ];

                foreach($app->children()->get() as $children) {
                    $apps[] = [
                        'auth_id' => $authorizationEmployeeData->id,
                        'app_id'  => $children->id,
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ];
                }

            }
            AuthorizationPermission::insert($apps);

            \DB::commit();
        }
        catch (\Exception $e) { // PHP 5
            \DB::rollback();
            session()->flash('error', 'حدث خطأ اثناء محاولة انشاء التفويض'); 
            return back()->withInput();
        }
        catch (\Throwable $e) { // PHP 7
            \DB::rollback();
            session()->flash('error', 'حدث خطأ اثناء محاولة انشاء التفويض'); 
            return back()->withInput();
        }

        session()->flash('success', 'تم انشاء التفويض بنجاح'); 
        return redirect()->route('authorization.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $authorizationEmployee = auth()->user()->employee()
            ->authorizationEmployees()
            ->with('employee', 'organization', 'authorizationPermissions')
            ->findOrFail($id);
    
        $appsIds = $authorizationEmployee->authorizationPermissions->pluck('app_id')->toArray();
        $apps    = AuthorizationPermission::mainDepartmentServicesApps($appsIds);

        return view('departmentservices::authorization.show', compact('authorizationEmployee', 'apps', 'appsIds'));
    }

    /**
     * remove authorization from employee
     */
    public function removeAuthorization(Request $request)
    {
        $authorizationEmployee = auth()->user()->employee()->authorizationEmployees()->findOrFail($request->id);
        $authorizationEmployee->auth_status = 2;
        $authorizationEmployee->save();
        session()->flash('success', 'تم الغاء التفويض بنجاح'); 
        return redirect()->route('authorization.index');
    }

    /**
     * search for employees that they are under my organization  
     */
    public function employeesSearch(Request $request)
    {
        $departmentData = HRDepartment::find($request->organization_id);

        if(empty($departmentData) || ($departmentData->direct_manager_m_id != auth()->user()->employeeObject->employee_id && $departmentData->direct_manager_f_id != auth()->user()->employeeObject->employee_id) ) {
            return [];
        }

        $employees = Employee::where('employee_id', '<>', auth()->user()->employeeObject->employee_id)
                            ->where(function($query) use ($request) {
                                $query->where('dept_code', $request->organization_id)
                                ->orWhere('real_dept_code', $request->organization_id);
                            })
                            ->where(function($query) use ($request) {
                                $query->where('arabic_name', 'like', '%' . $request->input('query') . '%')
                                ->orWhere('english_name', 'like', '%' . $request->input('query') . '%')
                                ->orWhere('employee_id', 'like', '%' . $request->input('query') . '%');
                            })
                            ->select('employee_id', 'arabic_name')
                            ->get();

        return $employees;
    }

}
