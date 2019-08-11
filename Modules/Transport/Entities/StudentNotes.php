<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Transport\Entities\MuStudent;
use Modules\Transport\Entities\StudentTrack;
use App\Classes\Date\CarbonHijri;
use Modules\Transport\Entities\Track;
use Carbon\Carbon;



class StudentNotes extends Model
{
    protected $table = 'trans_studentNotes';
    protected $fillable = ['student_id','content','reply'];
    protected $appends = ['student_name','track','hijri_date'];

    public function gethijriDateAttribute($value)
    {
        $value =CarbonHijri::toHijriFromMiladi($this->created_at);
        return Carbon::parse($value)->format('d-m-Y');
    }
    
    public function getStudentNameAttribute($value)
    {
        $value = MuStudent::where('student_id',$this->student_id)->first()->student_name;
        return $value;
    }

    public function getTrackAttribute($value)
    {
        $track_id = StudentTrack::where('student_id',$this->student_id)->first()->track_id;
        $track = Track::tracks('1',$track_id)->first()->track_ar;
        return $track;
    }

}
