<?php

namespace Modules\DepartmentServices\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PrmuEvents\Entities\PrmuEveRequest;
use Modules\PrmuEvents\Entities\PrmuEveCategory;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\PrmuEvents\Entities\PrmuEveTypes;
use Modules\PrmuEvents\Entities\PrmuEvePlace;
use Modules\PrmuEvents\Entities\PrmuEveBooking;
use Modules\PrmuEvents\Entities\PrmuEveGuests;
use Modules\PrmuEvents\Entities\PrmuEveSubs;
use Modules\PrmuEvents\Entities\PrmuEveCategoryEvents;
use Modules\PrmuEvents\Entities\PrmuEveSponsor;
use Modules\PrmuEvents\Entities\PrmuEveDeptLevel;
use Auth;
use File;
use Carbon\Carbon;

class PrmuEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
       //dd(Auth::user()->department()->id);
       if(Auth::user()->department()->id == 1){
         $is_rector = HRDepartment::where('direct_manager_m_id' , '=' , Auth::user()->employee()->employee_id)->get();
         if(count($is_rector)) {
           $requests = PrmuEveRequest::whereIn('status' , array(7, 8) )->get();
         }else{
           return view('un-authorized');
         }
       }elseif(Auth::user()->department()->id == 13){
         $is_rector = HRDepartment::where('direct_manager_m_id' , '=' , Auth::user()->employee()->employee_id)->get();
         if(count($is_rector)) {
           $requests = PrmuEveRequest::whereIn('status' , array(2,10))->where('sponsor' , 3 )->get();
         }else{
           return view('un-authorized');
         }
       }elseif(Auth::user()->department()->id == 12){
         $is_rector = HRDepartment::where('direct_manager_m_id' , '=' , Auth::user()->employee()->employee_id)->get();
         if(count($is_rector)) {
           $requests = PrmuEveRequest::whereIn('status' , array(2,10))->where('sponsor' , 4 )->get();
         }else{
           return view('un-authorized');
         }
       }elseif(Auth::user()->department()->id == 11){
         $is_rector = HRDepartment::where('direct_manager_m_id' , '=' , Auth::user()->employee()->employee_id)->get();
         if(count($is_rector)) {
           $requests = PrmuEveRequest::whereIn('status' , array(2,10))->where('sponsor' , 5 )->get();
         }else{
           return view('un-authorized');
         }
       }elseif(Auth::user()->department()->id == 4){
         $requests = PrmuEveRequest::whereIn('status' , array(2, 3) )->get();
       }else {
         // dd(Auth::user()->employeeObject->national_id );
          $requests = PrmuEveRequest::where('id_user' , Auth::user()->employeeObject->national_id )->get();
          if(count($requests) == 0 ){
            $is_mang = HRDepartment::where('direct_manager_m_id' , '=' , Auth::user()->employee()->employee_id)->get();
            if(count($is_mang) > 0 ){
              foreach ($is_mang as $key => $value) {
                $list_dept[] =  $value->id;
              }
              $requests = PrmuEveRequest::whereIn('id_department' , $list_dept )->where('status',1)->get();
            }
          }
       }
        return view('departmentservices::prmuevents.index',compact('requests'));
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function approvalFromManagerDept($id)
    {
      // dd($id);
        $requests = PrmuEveRequest::find($id);
        $requests->status = 2;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }

    /**
     * Update the status to number 3 inform others.
     * @param  Request $id
     * @return Response
     */
    public function inform($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 3;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }

    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function re($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 4;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * override conflict
     * @param  Request $id
     * @return Response
     */
    public function override($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->conflict = 2;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function changeTime($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 5;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function reCheck($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 6;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function gotoRector($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 7;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function approvalRector($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 8;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function refusalRector($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 9;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function approvalAgent($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 10;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function refusalAgent($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 11;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Reorder for note
     * @param  Request $id
     * @return Response
     */
    public function cancellation($id)
    {
        $requests = PrmuEveRequest::find($id);
        $requests->status = 12;
        $requests->save();
        return redirect('/department-services/prmuevents');
    }
    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create()
    {
        return view('departmentservices::create');
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
        return view('departmentservices::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('departmentservices::edit');
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
