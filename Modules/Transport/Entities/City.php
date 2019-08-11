<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'trans_city';
    protected $fillable = ['name_ar','name_en','created_at','updated_at'];
}
