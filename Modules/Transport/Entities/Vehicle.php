<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'trans_vehicles';
    protected $fillable = ['vehicle_number','plate_number','chair_number'];
}
