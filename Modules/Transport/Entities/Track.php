<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Track extends Model
{
    protected $table = 'trans_track';
    protected $fillable = ['city_id','district_id','college_id','created_at','track_number','updated_at'];

    public function citys()
    {
        return $this->belongsTo('Modules\Transport\Entities\City','city_id');
    }

    public function districts()
    {
        return $this->belongsTo('Modules\Transport\Entities\District','district_id');
    }

    public function colleges()
    {
        return $this->belongsTo('Modules\Core\Entities\Core\HRDepartment','college_id');
    }

    public static function tracks($paginate,$id=null)
    {
        $tracks =  Track::leftjoin('trans_city','trans_city.id','trans_track.city_id')
        ->leftjoin('trans_district','trans_district.id','trans_track.district_id')
        ->leftjoin('hr_departments','hr_departments.id','trans_track.college_id');
        if($id != null)
        {
            $tracks = $tracks->where('trans_track.id',$id);
        }
        $tracks = $tracks->orderBy('trans_track.id','desc')
        ->select('trans_track.id as track_id','trans_city.id as city_id',
         'trans_track.track_number as track_number',
         'hr_departments.id as college_id' , 'trans_district.id as district_id',
         DB::raw("(trans_city.name_ar || ' // ' || trans_district.name_ar || ' // ' || hr_departments.name) AS track_ar"),  // like concat function but concat  want  2  arguments 
         DB::raw("(trans_city.name_en || ' // ' || trans_district.name_en || ' // ' || hr_departments.name) AS track_en"),
         'hr_departments.name as college_name','trans_city.name_ar as city_name_ar','trans_city.name_en as city_name_en','trans_district.name_ar as district_name_ar','trans_district.name_en as district_name_en'
        );
        if($paginate == '0')
        return $tracks->paginate(10);
        else
        return $tracks->get();

    }


}
