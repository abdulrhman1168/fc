<?php

namespace Modules\Transport\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\DailyReport;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\UserBaseController;
use Validator;
use Modules\Auth\Entities\Core\User;
use Modules\Core\Entities\Core\Employee;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\Transport\Entities\EvaluatingReport;
use Carbon\Carbon;
use Auth;

class DailyReportsController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
      if ($request->wantsJson() || $request->ajax()) {

          $dailyReports = DailyReport::where('reporter_id', $request->user()->user_id)
                                     ->select(['id', 'report_date', 'status']);

          return Datatables::of($dailyReports)
             ->addColumn('action', 'transport::daily-reports.index-actions')
             ->editColumn('report_date', function (DailyReport $dailyReport) {
                    return $dailyReport->report_date->format('Y-m-d');
             })->editColumn('status', function (DailyReport $dailyReport) {
                    return $dailyReport->status == 1 ? __('transport::app.New') : __('transport::app.guidance_done');
             })->toJson();

      } else {
          return view('transport::daily-reports.index');
      }
    }

    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create(Request $request)
    {
      $dailyReport = new DailyReport();

      return view('transport::daily-reports.create')
             ->with('dailyReport', $dailyReport)
             ->with('degrees', DailyReport::degrees());
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $request->validate([
          'report_date' => 'required',
          'body' => 'required',
          'report_resource' => 'required',
          'degree' => 'required',
          'action_from_transport_office' => 'required'
      ]);

      $dailyReport = DailyReport::create([
        'report_date' => $request->report_date,
        'body' => $request->body,
        'report_resource' => $request->report_resource,
        'degree' => $request->degree,
        'action_from_transport_office' => $request->action_from_transport_office,
        'status' => 1,
        'reporter_id' => $request->user()->user_id
      ]);

      return redirect()->route('trans.daily-reports.show', ['id' => $dailyReport->id ]);

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $dailyReport = DailyReport::where('id', $id)
                                  ->where('reporter_id', $request->user()->user_id)
                                  ->first();

        return view('transport::daily-reports.show')
               ->with('dailyReport', $dailyReport)
               ->with('degrees', DailyReport::degrees());
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(Request $request, $id)
    {
      $dailyReport = DailyReport::where('id', $id)
                        ->where('reporter_id', $request->user()->user_id)
                        ->first();
      if($dailyReport->status == '2')
      {
        return redirect('transport/daily-reports');
      }
      return view('transport::daily-reports.edit')
              ->with('dailyReport', $dailyReport)
              ->with('degrees', DailyReport::degrees());
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
          'report_date' => 'required',
          'body' => 'required',
          'report_resource' => 'required',
          'degree' => 'required',
          'action_from_transport_office' => 'required'
      ]);

      $dailyReport = DailyReport::where('id', $id)
                                ->where('reporter_id', $request->user()->user_id)
                                ->first();
      $dailyReport->update(
        [
          'report_date' => $request->report_date,
          'body' => $request->body,
          'report_resource' => $request->report_resource,
          'degree' => $request->degree,
          'action_from_transport_office' => $request->action_from_transport_office
        ]
      );

      return view('transport::daily-reports.show')
             ->with('dailyReport', $dailyReport)
             ->with('degrees', DailyReport::degrees());
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function follow(Request $request)
    {
      if ($request->wantsJson() || $request->ajax()) {

          $dailyReports = DailyReport::join(User::table(), DailyReport::table().'.reporter_id', '=', User::table().'.user_id')
                                     ->leftJoin(Employee::table(), Employee::table().'.national_id', '=', User::table().'.user_idno')
                                     ->leftJoin(HRDepartment::table(), HRDepartment::table().'.id', '=', Employee::table().'.real_dept_code')
                                     ->orderBy(DailyReport::table().'.created_at', 'DESC')
                                     ->select(
                                     [
                                       DailyReport::table().'.*',
                                       User::table().'.user_name AS reporter_name',
                                       HRDepartment::table().'.name AS destination'
                                     ]);

          return Datatables::of($dailyReports)
             ->addColumn('action', 'transport::daily-reports.follow-index-actions')
             ->editColumn('report_date', function (DailyReport $dailyReport) {
                    return $dailyReport->report_date->format('Y-m-d');
             })->editColumn('status', function (DailyReport $dailyReport) {
                    return $dailyReport->status == 1 ? __('transport::app.New') : __('transport::app.guidance_done');
             })->editColumn('created_at', function (DailyReport $dailyReport) {
                    return toHijri($dailyReport->created_at->format('Y-m-d'));
             })->toJson();

      } else {
          return view('transport::daily-reports.follow');
      }
    }

    /**
     * Guide
     * @return Response
     */
    public function guide(Request $request, $id)
    {
      $dailyReport = DailyReport::where('id', $id)
                                ->where('reporter_id', $request->user()->user_id)
                                ->first();

      return view('transport::daily-reports.guide')
             ->with('dailyReport', $dailyReport)
             ->with('degrees', DailyReport::degrees());
    }

    /**
     * Guide report
     * @param  Request $request
     * @return Response
     */
    public function guidance(Request $request, $id)
    {
      $request->validate([
          'guidance' => 'required'
      ]);

      $dailyReport = DailyReport::where('id', $id)
                                ->where('reporter_id', $request->user()->user_id)
                                ->first();

      $dailyReport->update(
        [
          'guidance' => $request->guidance,
          'status' => 2
        ]
      );

      return redirect()->route('trans.daily-reports.follow');
    }

    public function supervision()
    {
        return view('transport::daily-reports.supervision-report-create');
    }

    public function storeSupervisionReport(Request $request)
    {      
        $validator = Validator::make($request->all(), [
            'login_no'=>'required|numeric',
            'uploade_reports_no'=>'required|numeric',
            'printed_reports_no'=>'required|numeric',
            'reports_from_system_no'=>'required|numeric',
            'daily_movement_uploaded'=>'required',
        ]);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
          $supervisor_id = Auth::user()->user_id;
          $request->merge(['supervisor_id' => $supervisor_id]);
          EvaluatingReport::create($request->all());
            return response(["تم إضافة التقييم  بنجاح",200]);
        }
    }

    public function supervisionIndex(Request $request)
    {
        

        if ($request->wantsJson() || $request->ajax()) {

          $reports = EvaluatingReport::reportsWithSupervisor();
          return Datatables::of($reports)
             ->addColumn('action', 'transport::daily-reports.supervision-index-actions')
             ->editColumn('dateTime', function (EvaluatingReport $reports) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $reports->created_at)->format('H:i:s') . ' في  ' .Carbon::createFromFormat('Y-m-d H:i:s', $reports->created_at)->format('Y-m-d');
             })->editColumn('status', function (EvaluatingReport $reports) {
                    return $reports->status == 0 ? __('transport::app.New') : __('transport::app.guidance_done');
             })->toJson();

      } else {
          return view('transport::daily-reports.supervision-reports-index');
      }
        
    }

    public function supervisionEvaluateShow(Request $request,$id)
    {
      $supervision_report = EvaluatingReport::findOrFail($id);
      if($supervision_report->status == '1')
      {
        return redirect('transport/reports/supervision/');
      }
      if ($request->type == 'vue')
      {
        
        return Response($supervision_report);
      }
      else
      {
        return view('transport::daily-reports.supervision-reports-show');    
      }
    }

    public function supervisionEvaluateStore(Request $request,$id)
    {
        $supervision_report = EvaluatingReport::findOrFail($id);
        $validator = Validator::make($request->all(), [
          'computer_unit'=>'required|numeric|max:20',
          'follow_unit'=>'required|numeric|max:10',
          'manager'=>'required|numeric|max:50',
          'supervision_unit'=>'required|numeric|max:20',
      ]);

      if ($validator->fails()) {
          return response(['errors'=>$validator->errors()],500);
      }
      else
      {
        $request->merge(['status' => '1']);
        $supervision_report->update($request->all());
          return response(["تم إضافة التقييم  بنجاح",200]);
      }

    }

    public function destroy($id)
    {
        $dailyReport = DailyReport::findOrFail($id)->delete();
        return redirect()->back();
    }

}
