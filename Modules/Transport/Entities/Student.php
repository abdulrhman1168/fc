<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Transport\Entities\StudentTrack;

class Student extends Model
{
  protected $table = 'trans_student';
  protected $fillable = ['activities','university_id','created_at','updated_at'];
  protected $appends = ['participate_transport'];

  public function getParticipateTransportAttribute($value)
  {
    $value = $this->university_id;
    $record = StudentTrack::where('student_id',$value)->first();
      return $record == null ? '0':'1';
  }
 /* protected $appends = ['transport_system'];

  public function getTransportSystemAttribute($value)
  {
     $value = $this->;
     $status = 5;
     return $value;
  }*/
  public static function getActivityStudents ($id)
  {
      $students  = self::leftJoin('mu_reference_students','mu_reference_students.student_id','university_id')
                  ->where('trans_student.activities',$id)
                   ->select('mu_reference_students.*','trans_student.*')
                   ->orderBy('created_at','DESC')
                   ->paginate(10);
      return $students;
  }
}
