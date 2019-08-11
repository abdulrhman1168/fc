<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class Phenomenon extends Model
{
    protected $fillable = ['phenomenon_status','phenomenon_type','place','actualtime','dayreality','track','attachment','created_at','updated_at','user_id'];
    protected $table = 'trans_phenomenons';

    public static function getAllData()
    {
        $phenomenons = Phenomenon::leftJoin('trans_track','trans_track.id','track')
        ->leftjoin('trans_city','trans_city.id','trans_track.city_id')
        ->leftjoin('trans_district','trans_district.id','trans_track.district_id')
        ->leftjoin('hr_departments','hr_departments.id','trans_track.college_id')
        ->orderBy('trans_track.id','desc')
        ->select('trans_phenomenons.*','trans_track.id as track_id','trans_city.id as city_id', 'hr_departments.id as college_id' , 'trans_district.id as district_id','hr_departments.name as college_name','trans_city.name_ar as city_name_ar','trans_city.name_en as city_name_en','trans_district.name_ar as district_name_ar','trans_district.name_en as district_name_en')
        ->get();
        return $phenomenons;
    }


}
