<?php

namespace Modules\Transport\Http\Controllers;

use App\Http\Controllers\UserBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Transport\Entities\City;
use Modules\Transport\Entities\District;
use Modules\Transport\Entities\Driver;
use Modules\Transport\Entities\Track;
use Modules\Transport\Entities\Student;
use Modules\Transport\Entities\MuStudent;
use Modules\Transport\Entities\AttendaceStudent;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\Transport\Entities\DailyMovement;
use Modules\Transport\Entities\StudentExcuess;
use Modules\Transport\Entities\SMSMessage;
use App\Classes\Sms\Mobily;
use App\Classes\Date\CarbonHijri;
use Carbon\Carbon;
use Validator;



class HomeController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $cities = City::all();
        $colleges = HRDepartment::where('type','=','2')->get();
        $drivers = Driver::all();
        $districts = District::all();
        
        return view('transport::home.index',compact('cities','colleges','drivers','districts'));
    }

    /**
     * Show the form for creating a New resource.
     * @return Response
     */
    public function create()
    {
        return view('transport::create');
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
        return view('transport::show');
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
    
    public function studentFilters(Request $request)
    {
        $students= MuStudent::search($request->q);
        return $students;
    }

    public function getDriverReport($track,$date, $id)
    {
        $drivers = Driver::drivers(0);
        $track_record = Track::tracks('1',$track);
        $drivers =  Driver::drivers(1,$id)->first();
        $students = MuStudent::getDriverStudents($id,$track);
        $date_name = CarbonHijri::toMiladiFromHijri($date)->hijriFormat('l');
        return Response(['driver'=> $drivers, 'track'=>$track_record[0],'students'=>$students,'date_name'=> $date_name]); 
    }

    public function homeFilters(Request $request)
    {
        $date =  $request->date ? CarbonHijri::toMiladiFromHijri( $request->date )->toDateString() :Carbon::now()->toDateString();
        $drivers = Driver::filterHome($request);
        $tracks = Driver::getTracksDriver($drivers->get(),$date);
        return Response(['drivers'=> $drivers->distinct()->paginate(10),'tracks'=>$tracks,'date' => $request->date]); 
    }

    public function getStudentsDriver($track,$id)
    {
        $students = MuStudent::getDriverStudents($id,$track);
        return Response($students); 
    }

    public function studentAttendaceStore(Request $request)
    {
        $date = $request->date ? CarbonHijri::toMiladiFromHijri($request->date): Carbon::today();
        $attendaceStudents = AttendaceStudent::exist($request->driver_id,$request->track_id,$date);
        if(count($attendaceStudents) > 0)
        {
            return response(['message'=>"بالفعل تم تسجيل حضور الطالبات اليوم",200]);
        }
        $validator = Validator::make($request->all(), [
            'time_arrival'=>'required',
            'driver_sign'=>'required',
            'supervisor_sign' => 'required',
            'supervisor_name' => 'required|string',
            'track_id' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        else
        {
            $vehicle_id = Driver::findOrFail($request->driver_id)->vehicle_id;
            $absenceStudents = serialize(array_filter($request->absenceStudents));
            AttendaceStudent::create([
                'driver_id' => $request->driver_id,
                'track_id' => $request->track_id,
                'vehicle_id' => $vehicle_id,
                'time_arrival' => $request->time_arrival,
                'driver_sign' => $request->driver_sign,
                'supervisor_sign' => $request->supervisor_sign,
                'supervisor_name' => $request->supervisor_name,
                'student_absence' => $absenceStudents,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
        return response(['message'=>"تم تحضير الطالبات بنجاح",200]);
    }

    public function getAttendaceStudentsReport($track,$date,$id)
    {
        $date = $date ? CarbonHijri::toMiladiFromHijri($date): Carbon::today();
        $driver = Driver::findOrFail($id);
        $students = MuStudent::getDriverStudents($id,$track);
        $report_data = AttendaceStudent::exist($id,$track,$date)->first();
        $report_data->count_students_absence = count(unserialize($report_data->student_absence));
        $report_data->count_students_exist = count($students);
        $students_absence = $this->filterStudent($students,unserialize($report_data->student_absence));
        return response(['students'=>$students,'driver'=>$driver,'attendace_report'=>$report_data]); 
    }

    public function filterStudent($students,$absence_ids)
    {
        foreach($students as $student)
        {
            if(in_array($student->student_id,$absence_ids))
            {
                $student->setAttribute('absence' , '1');
                
            }
        }
        return $students;
    }
    public function dailyMovementStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'duration'=>'required',
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }
        $report = $request->all();
        $date = $request->date ? CarbonHijri::toMiladiFromHijri($request->date): Carbon::today();
        $dailyMovement_report = DailyMovement::getDailyMovment($date,$request);
        if(count($dailyMovement_report) > 0)
        {
            return response(["بالفعل تم تسجيل  الحركة اليومية لهذه الفترة",200]);
        }
        $vehicle_id = Driver::findOrFail($request->driver_id)->vehicle_id;
        $dailyMovement_report = DailyMovement::create([
            'driver_id' => $report['driver_id'],
            'vehicle_id' => $vehicle_id,
            'status' => serialize($report['status']),
            'notes' => serialize($request['notes']),
            'created_at' => $date,
            'updated_at' => $date,
            'duration' => $request->duration,
        ]);
        return response(["تم حفظ البيانات بنجاح",200]);
    }
    
    public function getDailyMovementReport ($type,$date,$id)
    {
        $date = $date ? CarbonHijri::toMiladiFromHijri($date): Carbon::today();
        $dailyMovement_report = DailyMovement::whereDate('created_at', $date)
                                ->where('driver_id',$id)->where('duration',$type)->first();
        
        return response(['dailyMovementReport'=>$dailyMovement_report]);
    }

    public function getExcuess($track,$date,$id)
    {

        $excuess =  StudentExcuess::ExcuessData($track,$id,$date);
        return Response($excuess); 
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required',
            'option'=>'required',
            'message' => 'required',
            'track' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()],500);
        }

        $driver = Driver::findOrFail($request->id);
        $students = MuStudent::getDriverStudents_numbers($request->id,$request->track);  // Mobile_number column array
        if($request->option == 1)
        {
            $numbers = [$driver->mobile,$driver->companion_no];
        }
        elseif($request->option == 2 )
        {
            $numbers = $students;   
        }
        elseif($request->option == 12)
        {
            $numbers = array_merge([$driver->mobile,$driver->companion_no],$students);
        }

        //$message =  Mobily::send($request->message,$numbers);

        SMSMessage::create([
            'driver' => $request->id,
            'track' => $request->track,
            'receiver_status' => $request->option,
            'content' => $request->message,
            'hijridate' => CarbonHijri::toHijriFromMiladi(Carbon::now())
            //'send_status' => 0
        ]);
        return response(["message"=>"تم حفظ البيانات بنجاح",200]);
    }
    
    public function getMessages($track,$date,$id)
    {
        $date = $date ? CarbonHijri::toMiladiFromHijri($date): Carbon::today();
        $driver = Driver::where('id',$id)->get();
        $result = Track::tracks('1',$track);
        $messages = SMSMessage::where('driver',$id)->where('track',$track)->whereDate('created_at',$date)->paginate(10);
        return response(['messages' => $messages,'tracks' => $result[0]]);
    }
    
}
