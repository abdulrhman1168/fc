<?php

namespace Modules\DepartmentServices\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Auth;
use Validator;
use Carbon\Carbon;
use Modules\MyServices\Entities\MuTicket;
use Modules\Core\Entities\Core\HRDepartment;


class TravelAllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
         
        
          $ticket = MuTicket::getData();
                                   
          
        return view('departmentservices::travel_allow.index')
                ->with('ticket', $ticket);
     
      
    }
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $ticket = MuTicket::find($id);
        $escorts = unserialize($ticket->tickets_for);
        // dd($escorts);
        return view('myservices::travel_allow.show',compact('ticket','escorts'));
    }

    /**
     *
     *
     * @param  int  $id
     * @return Response
     */
    public function approval($id)
    {
      $ticket = MuTicket::find($id);
      $ticket->step = 2;
      $ticket->save();
      return redirect('/department-services/travelAllowance')->with('success', 'تم الاعتماد ');
    }

    /**
     *
     *
     * @param  int  $id
     * @return Response
     */
    public function notApproval($id)
    {
      $ticket = MuTicket::find($id);
      $ticket->step = 0;
      $ticket->save();
      return redirect('/department-services/travelAllowance')->with('success', 'تم رفض الإعتماد ');
    }
}
