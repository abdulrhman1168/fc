<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Transport\Entities\DriverTrack;
use Modules\Transport\Entities\StudentTrack;
use App\Classes\Date\CarbonHijri;
use DB;



class MuStudent extends Model
{
  protected $table = 'mu_reference_students';
  public static function search($query)
  {
    $students =  self::where('ststatu','منتظم')
                ->where('student_name', 'LIKE', '%'.$query.'%')
                ->OrWhere('student_id', 'LIKE', '%'.$query.'%')
                ->select('student_id','student_name','faculty')->get();
    return $students;
  }



  public static function getDriverStudents($id,$track=null)
  {
      $tracks = DriverTrack::where('driver_id',$id)->pluck('track_id')->toArray();     
      $students = StudentTrack::whereIn('track_id',$tracks)
                ->join('mu_students','mu_students.student_id','student_track.student_id')
                ->leftJoin('mu_reference_students','mu_reference_students.student_id','student_track.student_id')
                ->where('driver_id',$id)
                ->Where('current_status', 1);
                if($track)
                {
                  $students = $students->where('student_track.track_id',$track);
                }
                $students = $students->select('mu_reference_students.*','student_track.student_idno as idno','student_track.student_id as st_id' )
                ->orderBy('mu_reference_students.faculty')
                ->get();

      return $students;
  }

  public static function getDriverStudents_numbers($id,$track)
  {
      
      $students = StudentTrack::where('track_id',$track)
               ->where('driver_id',$id)
                ->leftJoin('mu_reference_students','mu_reference_students.student_id','student_track.student_id')
                ->pluck('mu_reference_students.mobile_phone' )
                ->toArray();

      return $students;
  }
}
