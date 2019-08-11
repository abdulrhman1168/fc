<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Core\User;
use Modules\Transport\Entities\Student;
use App\Classes\Date\CarbonHijri;
use Carbon\Carbon;


class Activity extends Model
{
    protected $table = 'trans_activities';
    protected $fillable = ['user_id','coordinator','coordinator_mobile', 'service_organization' , 'destination' , 'location' , 'transport_date' , 'transport_going' , 'transport_back' , 'students_count' , 'coordinators_count' ,'created_at','updated_at' , 'deandecision','transportationguidance'];
    protected $appends = ['hijri_date'];

    public function gethijriDateAttribute($value)
    {
        $value =CarbonHijri::toHijriFromMiladi($this->created_at);
        return Carbon::parse($value)->format('d-m-Y');
    }

 
        public function userObject() {
          return $this->belongsTo(User::class, 'user_id');
        }
}
