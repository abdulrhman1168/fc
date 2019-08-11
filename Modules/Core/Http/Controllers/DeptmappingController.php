<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserBaseController;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\Core\Entities\Core\MUDepartment;
use Modules\Core\Entities\DeptMapping;


class DeptmappingController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $hr_departments = DeptMapping::select('id','hr_departments','mu_departments')->get();
        $mu_departments = MUDepartment::pluck('dep_arname','dep_no');
        return view('core::deptmapping/index',compact('hr_departments','mu_departments'));
    }

    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create()
    {
        return view('core::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        foreach ($request->input('row') as $k => $v){
            DeptMapping::where(['hr_departments'=>$k])->update(['mu_departments'=> $v]);
        }
        return redirect()->back();
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
    public function destroy()
    {
    }
}
