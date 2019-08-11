<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Date\CarbonHijri;
use Carbon\Carbon;
use DB;



class DailyMovement extends Model
{
  protected $table = 'trans_dailyMovement';
  protected $fillable = ['driver_id','vehicle_id','status','notes','duration','created_at','updated_at','guidence'];
  protected $appends = ['created_date','hijri_date'];

  public function getCreatedDateAttribute($value)
  {
      $value = $this->created_at;
      return Carbon::parse($value)->format('d-m-Y');
  }

  public function getNotesAttribute($value)
  {
    return unserialize($value);
  }

  public function getStatusAttribute($value)
  {
    return array_filter(unserialize($value));
  }

  public function gethijriDateAttribute($value)
  {
      $value =CarbonHijri::toHijriFromMiladi($this->created_at);
      return Carbon::parse($value)->format('d-m-Y');
  }

  public static function getDailyMovment($date,$request)
  {
      $report = $request->all();
      $result = DailyMovement::whereDate('created_at', $date)->where('duration',$report['duration'])
                ->where('driver_id',$report['driver_id'])->get();
      return $result;
  }

  public static function getAllRecords()
  {
    $dailymovement  = DailyMovement::leftJoin('trans_driver_track','trans_driver_track.driver_id','trans_dailyMovement.driver_id')
                      ->leftJoin('trans_track','trans_track.id','trans_driver_track.track_id')
                      ->leftJoin('hr_departments','hr_departments.id','trans_track.college_id')
                      ->select('hr_departments.name','hr_departments.id','trans_dailyMovement.created_at','trans_dailyMovement.duration','trans_dailyMovement.guidence')
                      ->groupBy('hr_departments.name','hr_departments.id','trans_dailyMovement.created_at','trans_dailyMovement.duration','trans_dailyMovement.guidence')
                      ->orderBy('trans_dailyMovement.created_at','DESC')
                      ->paginate(10);

    
    return $dailymovement;
  }

  public static function getAllDailyMovmentColleges($id,$date,$type)
  {
    $dailymovement  = DailyMovement::leftJoin('trans_driver_track','trans_driver_track.driver_id','trans_dailyMovement.driver_id')
                        ->leftJoin('trans_driver','trans_driver.id','trans_driver_track.driver_id')
                        ->leftJoin('trans_track','trans_track.id','trans_driver_track.track_id')
                        ->leftjoin('trans_city','trans_city.id','trans_track.city_id')
                        ->leftjoin('trans_district','trans_district.id','trans_track.district_id')
                        ->leftJoin('hr_departments','hr_departments.id','trans_track.college_id')
                        ->where('hr_departments.id',$id)->where('trans_dailyMovement.duration',$type)
                        ->whereDate('trans_dailyMovement.created_at',Carbon::parse($date))
                        ->select('trans_dailyMovement.*','hr_departments.name as college_name','hr_departments.id','trans_driver.name',
                        DB::raw("(trans_city.name_ar || ' // ' || trans_district.name_ar || ' // ' || hr_departments.name) AS track_ar"),  // like concat function but concat  want  2  arguments 
                        DB::raw("(trans_city.name_en || ' // ' || trans_district.name_en || ' // ' || hr_departments.name) AS track_en")
                        )
                        ->get();
                        
    return $dailymovement;
        
  }

  public static function updateGuidence($data)
  {
     $reports_ids = DailyMovement::leftJoin('trans_driver_track','trans_driver_track.driver_id','trans_dailyMovement.driver_id')
                       ->leftJoin('trans_track','trans_track.id','trans_driver_track.track_id')
                        ->leftJoin('hr_departments','hr_departments.id','trans_track.college_id')
                        ->where('hr_departments.id',$data['id'])->where('trans_dailyMovement.duration',$data['duration'])
                        ->where('trans_dailyMovement.guidence',0)
                        ->whereDate('trans_dailyMovement.created_at',Carbon::parse($data['date']))
                        ->pluck('trans_dailyMovement.id');
    $update_guidence = DailyMovement::whereIn('id',$reports_ids)->update(['guidence' => '1']);
    return $update_guidence;
  }




}
