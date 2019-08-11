<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Transport\Entities\City;

class District extends Model
{

    protected $table = "trans_district";
    protected $fillable = ['city_id','name_ar','name_en','created_at','updated_at'];

    public function cityObject() {
      return $this->belongsTo(City::class, 'city');
    }

    public static  function districts()
    {
      return District::leftjoin('trans_city','trans_city.id','city')
        ->select('trans_district.*','trans_city.name_ar as city_name_ar','trans_city.name_en as city_name_en')
        ->get();

    }
}
