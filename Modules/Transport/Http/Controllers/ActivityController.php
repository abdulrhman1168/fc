<?php

namespace Modules\Transport\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\Activity;
use Modules\Transport\Entities\Student;
use Modules\Transport\Entities\Driver;
use Modules\Transport\Entities\MuStudent;
use Modules\Transport\Entities\SMSMessage;
use App\Classes\Date\CarbonHijri;
use Illuminate\Validation\Rule;
use App\Classes\Sms\Mobily;
use Carbon\Carbon;
use Validator;
use Auth;




class ActivityController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      return view('transport::activities.activities');
    }

    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create(Request $request)
    {
      return view('transport::activities.activity-create');
    }


    public function deandecision (Request $request)

    {
      $request->validate([
        'deandecision'=>'required',
      ]);
      $id = $request->input('id');
      $activity = Activity::find($id);
      $activity->deandecision= $request->input('deandecision');
      $activity->save();
      return back()->with('success',"تم الإقرار بنجاح");


    }


    public function guidance(Request $request)

    {

      $id = $request->input('id');
      $activity = Activity::find($id);
      if($activity->deandecision == null)
      {
        $request->session()->flash('error', 'لابد اختيار قرار الجهة المسئولة');
        return redirect()->back()->withInput();
      }
      $request->validate([
        'transportationguidance'=>'required',
      ]);

      $activity->transportationguidance= $request->input('transportationguidance');
      $activity->save();
      return back()->with('success',"تم التوجيه بنجاح");




    }



    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      
      $request->merge(['transport_miladi_date' => CarbonHijri::toMiladiFromHijri($request->transport_date),'user_id' => Auth::user()->user_id])->format('yyyy-mm-dd');
      $validator = Validator::make($request->all(), [
        'coordinator'=>'required',
        'coordinator_mobile'=>'required|phone_number',
        'service_organization'=>'required',
        'destination'=>'required',
        'location'=>'required',
        'transport_miladi_date'=>'required|date|after:today',
        'transport_going'=>'required',
        'transport_back'=>'required',
        'students_count'=>'required',
        'coordinators_count'=>'required',
    ]);

    if ($validator->fails()) {
        return response(['errors'=>$validator->errors()],500);
    }
    else
    {
      if($request->students_count != count($request->students_ids))
      {
        return response(['errors' =>['students_count'=>['لابد ان يكون عدد الطالبات يساوي عدد الاسماء المختارة'],] ]);
      }
      $activity =  Activity::create($request->all());
      $id = $activity->id;

      $count = count($request->input('students_ids'));

      for($i=0 ; $i<$count ; $i++)
      {
        $student = new Student();
        $student->activities = $id ;
        $student->university_id = $request->input('students_ids')[$i]['student_id'];
        $student->save();
      }
        return response(['message' => 'success']);
    }


    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $activity = Activity::find($id);
        return view('transport::activities.show',compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('transport::edit');
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

    public function getActivties()
    {
      $activites = Activity::paginate(10);
      return response($activites);
    }

    public function getActivityStudents($id)
    {
      $students = Student::getActivityStudents($id);
      return response($students);
    }

    public function aproveActivity(Request $request,$id)
    {
      $activity = Activity::find($id);
      if($activity->deandecision != null)
        return response(['message'=>'بالفعل تم الاعتماد سابقا']);
      
      $validator = Validator::make($request->all(), [
        'status'=>'required',
        'driver_id'=>'required_if:status,1'
    ]);
    if ($validator->fails()) {
      return response(['errors'=>$validator->errors()],500);
    }


    $activity->deandecision= $request->status;
    $activity->transportationguidance= 'تم التوجيه';
    if($request->driver_id)
    {
      $driver = Driver::findOrFail($request->driver_id);
      $activity->driver_id = $request->driver_id;
      $message = " تم الموافقة علي طلب نقل النشاط وسيكون سائق النشاط هو " . $driver->name  . " رقم الجوال " . $driver->mobile;
      $message =  Mobily::send($message,[$activity->coordinator_mobile]);
    }
    $activity->save();

    return response(['message' => 'تم اعتماد الطلب']);
  }


    public function searchStudents(Request $request)
    { 
        $students =   MuStudent::search($request->get('query'));
        return Response($students);
    }
}
