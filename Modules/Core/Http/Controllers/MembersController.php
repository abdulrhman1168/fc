<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserBaseController;
use Modules\Auth\Entities\Core\Member;
use Modules\Core\Entities\Permission;
use Yajra\Datatables\Datatables;

class MembersController extends UserBaseController
{
    /**
     * Display a listing of the apps.
     * @return Response
     */
    public function index(Request $request)
    {
       
        if ($request->wantsJson() || $request->ajax()) {
            $users = Member::select('id','name','email', 'mobile', 'id_no');
            
            return Datatables::of($users)
               ->addColumn('action', function ($user) {
                   return '
                    

                   

                    

                   

                    ';
               })
               ->make(true);
        } else {
            return view('core::members.index');
        }
    }

    public function search(Request $request)
    {
      $users = User::search($request->input('query'))
                   ->select('id', 'name')
                   ->get();

      return $users;
    }


    public function edit(Request $request, $id)
    {
        $memberData = Member::findOrFail($id);
        return view('core::members.member_edit', compact('memberData'));
    }

 
}
