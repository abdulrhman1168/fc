<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class DriverTrack extends Model
{
    protected $table = "trans_driver_track";
    protected $fillable = ['driver_id','track_id'];
    protected $primaryKey = null;
    public $incrementing = false;
}
