<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class StudentTrack extends Model
{
  protected $table = 'student_track';
  protected $fillable = ['student_id','student_idno','track_id','driver_id'];
}
