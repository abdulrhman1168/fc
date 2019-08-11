<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Core\User;

class DailyReport extends Model
{

  use \Modules\Core\Traits\SharedModel;
  
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'trans_daily_reports';

  /**
   * Dates Attributes
   *
   * @var string
   */
  protected $dates = ['report_date', 'created_at', 'updated_at'];


  /**
   * The attributes that are mass assignable
   *
   * @var array
   */
  protected $fillable = ['reporter_id', 'report_date', 'body', 'report_resource', 'degree', 'action_from_transport_office', 'status', 'guidance'];


  public static function degrees() {
    return [
      1 => __('transport::app.New'),
      2 => __('transport::app.repeated')
    ];
  }

  public static function status() {
    return [
      1 => __('transport::app.New'),
      2 => __('transport::app.guidance_done')
    ];
  }

  public function reporter()
  {
    return $this->belongsTo(User::class, 'reporter_id');
  }
}
