<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Transport\Entities\City;

class AttendaceStudent extends Model
{

    protected $table = "trans_attendaceStudents";
    protected $fillable = ['driver_id','track_id','vehicle_id','student_absence','time_arrival','driver_sign','supervisor_sign','supervisor_name','created_at','updated_at'];
    public static function exist($driver_id,$track_id,$date)
    {
        $records =  self::where('driver_id',$driver_id)
                         ->where('track_id',$track_id)
                         ->whereDate('created_at',$date)
                         ->get();
        return $records;

    }
}
