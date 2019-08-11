<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserBaseController;
use Modules\Core\Entities\Department;
use Modules\Core\Http\Requests\DepartmentRequest;
use Modules\Auth\Entities\Core\User;
class DepartmentsController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
     
        $departments = Department::with('children')
            
            ->get();
            
        return view('core::departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $parent = 0;
        if ($request->has('parent_id')) {
            $parent = $request->input('parent_id');
        }

        $user = 0;
        if ($request->has('user_id')) {
            $user = $request->input('user_id');
        }
        $departments = $this->getSelectDepartments();
        $users = $this->getSelectUser();
        $department->user_id = 0;
        return view('core::departments.create', compact('departments','department', 'parent', 'users','user'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  DepartmentRequest $request
     * @return Response
     */
    public function store(DepartmentRequest $request)
    {
        Department::create($request->all());
        return redirect(route('departments.index'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Department $department
     * @return Response
     */
    public function edit(Department $department)
    {
        

        $departments = $this->getSelectDepartments();
        $users = $this->getSelectUser();
        return view('core::departments.edit', compact('department', 'departments', 'users'));
    }

    /**
     * Update the specified resource in storage.
     * @param  DepartmentRequest $request
     * @param Department $department
     * @return Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->all());
        return redirect(route('departments.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Department $department
     * @return Response
     * @throws \Exception
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect(route('departments.index'));
    }

    /**
     * @return array
     */
    public function getSelectDepartments(): array
    {
        $departments = Department::all()->pluck('name_ar', 'id')->toArray();
        $departments[0] = '-';
        ksort($departments);
        return $departments;
    }

    public function getSelectUser(): array
    {
        $users = User::all()->pluck('user_name', 'user_id')->toArray();
        $users[0] = '-';
        ksort($users);
        return $users;
    }
}
