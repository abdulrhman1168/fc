<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Permission;
use Modules\Core\Entities\Core\HRDepartment;
use App\Http\Controllers\UserBaseController;
use Modules\Auth\Entities\Core\User;
use Auth;
use Validator;

class DailyMovementPermission extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $Permission = Permission::all();
        $HRDepartment     = new HRDepartment();
        $real_dept_code   = $HRDepartment->Where('type', 2)
                        ->orWhereIn('id',[5941, 209])
                        ->pluck('name', 'id')->all();
        $real_dept_code   = [0 => 'يرجى الإختيار', 9999 => 'جميع الكليات'] + $real_dept_code;
        return view('core::deilyPermission.index',compact('Permission','real_dept_code'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'perm_id' => 'required|numeric',
          ])->validate();
          
        $data['user_id'] = $request->input('user_id');
        $data['perm_id'] = $request->input('perm_id');
        $query = Permission::Where('user_id',$data['user_id'])
                            ->Where('perm_id',$data['perm_id'])
                            ->count();

        if ($query === 0) {
            Permission::create($data);
            return redirect('/core/deilyPermission')->with('success', 'تمت إضافة الموظف بنجاح ');
        }

        return redirect('/core/deilyPermission')->with('success', 'الموظف مضاف مسبقا');
        
    }


    public function getEmployeeData($user_mail)
    {
       

        $employeeData = User::where('user_mail', $user_mail)
                                ->select(User::table().'.user_name', User::table().'.user_id')
                                ->first();

        if($employeeData == NULL) {
            return response()->json(['alert_type' => 'danger', 'message' => __('الإيميل غير صحيح')]);
        }
        
        return response()->json(['alert_type' => 'success', 'message' => $employeeData->user_name, 'user_id' => $employeeData->user_id]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('core::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('core::edit');
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
    public function destroy($id)
    {
        Permission::destroy($id); 
    return redirect('/core/deilyPermission')->with('success', 'تم حذف الصلاحية');
    }
}
