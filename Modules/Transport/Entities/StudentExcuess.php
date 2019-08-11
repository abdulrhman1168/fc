<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Date\CarbonHijri;
use Carbon\Carbon;
use DB;

class StudentExcuess extends Model
{
    protected $table = 'trans_student_excuess';
    protected $fillable = ['driver_id','student_id','status','hijridate','track'];
    public static function ExcuessData($track=null,$id=null,$date=null)  // show all excuess  or specific excuess with date and id 
    {
        if($id)
        $date = $date ? CarbonHijri::toMiladiFromHijri($date): Carbon::today();

        $excuess =  StudentExcuess::leftJoin('mu_reference_students','trans_student_excuess.student_id','mu_reference_students.student_id')
                    ->leftJoin('student_track','student_track.student_id','mu_reference_students.student_id')
                    ->leftJoin('trans_track','student_track.track_id','trans_track.id')
                    ->leftjoin('trans_city','trans_city.id','trans_track.city_id')
                    ->leftjoin('trans_district','trans_district.id','trans_track.district_id')
                    ->leftjoin('hr_departments','hr_departments.id','trans_track.college_id');
                    if($id !=null)
                    {
                        $excuess = $excuess->where('trans_student_excuess.driver_id',$id)
                                    ->where('trans_student_excuess.track',$track)
                                    ->whereDate('trans_student_excuess.created_at',$date);
                    }

                    $excuess = $excuess->select('mu_reference_students.*','trans_student_excuess.hijridate','trans_student_excuess.status','mu_reference_students.student_name' ,   
                    DB::raw("(trans_city.name_ar || ' // ' || trans_district.name_ar || ' // ' || hr_departments.name) AS track_ar"))  // like concat function but concat  want  2  arguments 
                    ->get(); 
        return $excuess;
    }
}
