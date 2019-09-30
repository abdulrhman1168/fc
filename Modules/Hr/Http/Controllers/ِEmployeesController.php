<?php

namespace Modules\Hr\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserBaseController;
use Illuminate\Routing\Controller;
use Yajra\Datatables\Datatables;
use Modules\Auth\Entities\Core\User;

use Validator;
class ِEmployeesController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        
        if ($request->wantsJson() || $request->ajax()) {
            $users = User::select('user_id','user_empno','user_name', 'user_mail', 'user_idno', 'is_super_admin');

            return Datatables::of($users)
               ->addColumn('action', function ($user) {
                   return '
                  

                  

                    <a href="'.route('user_employee_information', ['id' => $user->user_id]).'" class="btn btn-xs btn-primary">
                        <i class="fa fa-key"></i> التفاصيل
                    </a>

                

                    ';
               })
               ->make(true);
        } else {
            return view('hr::employee.index');
        }

        
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
       
        return view('hr::employee.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_name' => 'required|numeric',
            
        ]);

        $validator->after(function ($validator) use ($request) {

            User::create($request->all());
        return redirect(route('employees'));

        });

        //Validation
      
            $validator->validate();
        
       
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('hr::edit');
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
