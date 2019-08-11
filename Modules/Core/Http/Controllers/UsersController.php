<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserBaseController;
use Modules\Core\Transformers\User as UserTransformer;
use Modules\Auth\Entities\Core\User;
use Modules\Core\Entities\Permission;
use Yajra\Datatables\Datatables;

class UsersController extends UserBaseController
{
    /**
     * Display a listing of the apps.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            $users = User::select('user_id','user_empno','user_name', 'user_mail', 'user_idno', 'is_super_admin');

            return Datatables::of($users)
               ->addColumn('action', function ($user) {
                   return '
                    <a href="'.route('user_permissions', ['id' => $user->user_id]).'" class="btn btn-xs btn-primary">
                        <i class="fa fa-key"></i> '. __('messages.permissions') .'
                    </a>

                    <a href="'.route('user_superadmin', ['id' => $user->user_id]).'" class="btn btn-xs btn-'. ($user->is_super_admin == 1 ? 'danger' : 'primary') .' makeSuperAdmin">
                        <i class="fa fa-key"></i> Admin
                    </a>

                    <a href="'.route('user_employee_information', ['id' => $user->user_id]).'" class="btn btn-xs btn-primary">
                        <i class="fa fa-key"></i> Employee Information
                    </a>

                    <a href="'.route('change', ['id' => $user->user_mail]).'" class="btn btn-xs btn purple-plum">
                        <i class="fa fa-sign-in"></i> Access To User
                    </a>

                    ';
               })
               ->make(true);
        } else {
            return view('core::users.index');
        }
    }

    public function search(Request $request)
    {
      $users = User::search($request->input('query'))
                   ->select('user_id', 'user_name')
                   ->get();

      return $users;
    }

    public function makeSuperAdmin(Request $request, $id)
    {
        $userData = User::findOrFail($id);

        if ($request->isMethod('put')) {
            $userData->is_super_admin = ($userData->is_super_admin == 0 ? 1 : 0);
            $userData->save();
            return redirect('core/users');
        }

        return view('core::users.make-super-admin', compact('userData'));
    }

    public function employeeInformation(Request $request, $id)
    {
        $userData = User::findOrFail($id);
        $employeeData = optional($userData->employee());
        $departmentsData = optional($userData->employeeObject)->departmentsData();
        return view('core::users.employee-information', compact('userData', 'employeeData', 'departmentsData'));
    }

    public function change(Request $request, $email)
    {
        if(in_array(auth()->user()->user_idno, [1067469328, 1066369883]))
        {
            $userData = User::where('user_mail', '=', $email )->first();
            if($userData != NULL)
                auth()->login($userData);
        }

        return back();
    }
}
