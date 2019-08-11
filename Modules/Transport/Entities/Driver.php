<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Transport\Entities\DriverTrack;
use Modules\Transport\Entities\Permission;
use Modules\Transport\Entities\Track;
use Modules\Transport\Entities\File;

use Carbon\Carbon;

use Auth;


class Driver extends Model
{
    protected $table = "trans_driver";
    protected $fillable = ['name','mobile','companion','companion_no','vehicle_id'];
 
    public static function drivers($paginate,$id=null)
    {
        $allCollege = Permission::join('mu_users','mu_users.user_id', 'trans_permission.user_id')
        ->Where('trans_permission.perm_id',9999)
        ->Where('trans_permission.user_id', Auth::user()->user_id)
        ->first();
                                
        
        $drivers = Driver::leftjoin('trans_vehicles','trans_vehicles.id','trans_driver.vehicle_id')
                            ->leftjoin('trans_driver_track','trans_driver_track.driver_id','trans_driver.id')
                            ->leftjoin('trans_track','trans_track.id','trans_driver_track.track_id');
      if (  $allCollege === null ) {
        $drivers->join('trans_permission','trans_permission.perm_id','trans_track.college_id');
                            
        $drivers = $drivers->Where('trans_permission.user_id', Auth::user()->user_id);
              
      }
        if($id !== null)
        {
            $drivers = $drivers->where('trans_driver.id',$id);
        }

        
        $drivers = $drivers->select('trans_driver.*','trans_vehicles.vehicle_number as vehicle_number','trans_vehicles.plate_number as plate_number');
        if($paginate == '0')
        return $drivers->orderBy('trans_driver.created_at','desc');
        else
        return $drivers->get();

    }

    public static function getTracksDriver($drivers,$date=null)
    {
        $date = $date ? $date:Carbon::today();
        $result = [];
        $attendace_record_exist = [];
        $dailyMovement_m_exist = [];
        $dailyMovement_e_exist = [];

        foreach($drivers as $key => $driver)
        {
            // flag to hide button of attendace students of this day
            // res[$result,$flag]
            $dailyMovementReport_m = DailyMovement::whereDate('created_at', $date)
                                    ->where('duration',1)->where('driver_id',$driver->id)->first();
            $dailyMovementReport_e = DailyMovement::whereDate('created_at', $date)
                                    ->where('duration',2)->where('driver_id',$driver->id)->first();
            $attendace_report = AttendaceStudent::where('driver_id',$driver->id)->whereDate('created_at',$date)->first();
            if($attendace_report)
            {
                $attendace_record_exist[$driver->id] = '1' ; 
            }
            else
            {
                $attendace_record_exist[$driver->id] = '0' ; 
            }
            $dailyMovement_m_exist[$driver->id] = $dailyMovementReport_m;
            $dailyMovement_e_exist[$driver->id] = $dailyMovementReport_e;

            $driver_tracks = DriverTrack::where('driver_id',$driver->id)->get();
            foreach($driver_tracks as $key1 =>$track)
            {
                $track = Track::findOrFail($track->track_id);
                $track  = $track->tracks('1',$track->id)->first();        //  '1'  is no paginate 
                $result[$driver->id][$key1]['track_ar'] = $track->track_ar;
                $result[$driver->id][$key1]['track_en'] = $track->track_en;
                $result[$driver->id][$key1]['college'] = $track->college_name;
                $result[$driver->id][$key1]['track_id'] = $track->track_id;
                $result[$driver->id][$key1]['track_number'] = $track->track_number;
                $result[$driver->id][$key1]['date'] = $track->date;

            }
        }
        return [$result,$attendace_record_exist,$dailyMovement_m_exist,$dailyMovement_e_exist];
    }


    public static function filterHome($request)
    {
        $drivers = Driver::leftJoin('trans_driver_track','trans_driver_track.driver_id','trans_driver.id')
                          ->leftJoin('trans_track','trans_track.id','trans_driver_track.track_id')
                          ->leftJoin('student_track','student_track.driver_id','trans_driver.id')
                          ->leftjoin('trans_vehicles','trans_vehicles.id','trans_driver.vehicle_id')
                          ->leftJoin('mu_students','mu_students.student_id','student_track.student_id');

        if($request->driver)
        {
            $drivers = $drivers->where('trans_driver.id',$request->driver);
        }
        if($request->city)
        {
            $drivers = $drivers->where('trans_track.city_id',$request->city);
        }
        if($request->track)
        {
            $drivers = $drivers->where('trans_track.id',$request->track);
        }
        if($request->district)
        {
            $drivers = $drivers->where('trans_track.district_id',$request->district);
        }
        if($request->college)
        {
            $drivers = $drivers->where('trans_track.college_id',$request->college);
        }
        if($request->student)
        {
            $drivers = $drivers->where('mu_students.student_id',$request->student['student_id']);

        }


        $drivers = $drivers->select('trans_driver.*','trans_vehicles.vehicle_number as vehicle_number','trans_vehicles.plate_number as plate_number')->orderBy('trans_driver.created_at','desc');
        return $drivers;
    }

    public function Files()
    {
        return $this->hasMany(File::class,'model_id')->orderBy('created_at','DESC')->take(4);
    }
    
}
