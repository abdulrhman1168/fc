<?php

namespace Modules\DepartmentServices\Entities\Attendance;

use Illuminate\Database\Eloquent\Model;

use Modules\DepartmentServices\Entities\Attendance\MonthAbsence;

class SalaryDiscountRequestEmployee extends Model
{

  use \Modules\Core\Traits\SharedModel;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'es_salary_discount_req_emps';

  public function monthData() {

    return $this->belongsTo(MonthAbsence::class, 'employee_id', 'emp_jobid')
                ->where('hijri_month', $this->month)
                ->first();
  }
}
