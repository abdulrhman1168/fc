<?php

namespace Modules\DepartmentServices\Entities\Attendance;

use Illuminate\Database\Eloquent\Model;

class MonthAbsence extends Model
{

  use \Modules\Core\Traits\SharedModel;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'ATT.EsUser_Absence_Per_Month';

  public function totalLate()
  {
    return str_replace(["days", "Minutes", "Hours"], [__('departmentservices::app.days'), __('departmentservices::app.minutes'), __('departmentservices::app.hours')],$this->overall_late);
  }

  public function display()
  {
    if ($this->numof_absentdays > 0  || $this->late_hours > 0) {

      return true;
    } else {

      return false;
    }
  }

  public function absenceDaysNumbers()
  {
    if ($this->numof_absentdays > 0) {

      $days = [];

      $days = [];

      foreach(explode(',', $this->all_absent_dates) as $day) {

        $days[] = "(" . explode("-",str_replace([")","("], "", $day))[2] . ")";
      }

      return implode(" - ", $days);
    }

    return "";
  }
}
