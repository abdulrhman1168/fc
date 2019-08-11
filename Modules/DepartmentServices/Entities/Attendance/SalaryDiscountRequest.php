<?php

namespace Modules\DepartmentServices\Entities\Attendance;

use Illuminate\Database\Eloquent\Model;
use Modules\DepartmentServices\Entities\Attendance\SalaryDiscountRequestEmployee;
use Modules\Core\Entities\Core\HRDepartment;


use Modules\Auth\Entities\Core\User;

use Auth;

use App\Classes\Date\CarbonHijri;

class SalaryDiscountRequest extends Model
{

  use \Modules\Core\Traits\SharedModel;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'es_salary_discount_requests';

  //protected $dates = ['approval_date'];

  public function employees()
  {
      return $this->hasMany(SalaryDiscountRequestEmployee::class, 'request_id');
  }

  public function creator()
  {
    return $this->belongsTo(User::class, 'created_by_user_id', 'user_id');
  }

  public function approval()
  {
    return $this->belongsTo(User::class, 'approved_by_user_id', 'user_id');
  }

  public function approvalStatus()
  {
    if($this->approved_by_user_id == null) {

      return __('departmentservices::app.waiting_approve');

    } else {

      return __('departmentservices::app.approved') . ' ' .
             __('departmentservices::app.by') . ' ' .
             $this->approval->employeeObject->arabic_name . ' '.
             $this->approval_date ;
    }
  }

  public function department()
  {
      return $this->belongsTo(HRDepartment::class, 'department_id');
  }

  public function hasAbilityToApprove()
  {
    $employeeId = Auth::user()->employeeObject->employee_id;
    $validUser = $this->department->direct_manager_m_id == $employeeId || $this->department->direct_manager_f_id == $employeeId;

    if($validUser && $this->approved_by_user_id == null)
    {
      return true;
    } else {
      return false;
    }
  }

  public static function authorizedRequests($filters = [])
  {
    
    if (Auth::user()->isAllAccess()) {

      return self::whereNotNull(self::table().'.approved_by_user_id')
                 ->when(isset($filters['id']),  function($query) use ($filters) {

                        return $query->where(self::table().'.id', '=', $filters['id']);
                        
                 });

    } else {

      return self::where(function ($query) {

                      $query->where(self::table().'.department_id', '=' ,Auth::user()->employeeObject->real_dept_code)
                            ->orWhereIn(self::table().'.department_id', Auth::user()->employeeObject->departmentsManage()->pluck('id')->toArray());

                 })->when(isset($filters['id']),  function($query) use ($filters) {

                  return $query->where(self::table().'.id', '=',$filters['id']);

                });
    }
  }

  /**
   * Get request number
   *
   * @return string
   */
  public function getRequestNumberAttribute()
  {
      $yearMonth = explode("-", $this->month);
      $month = $yearMonth[1];
      $year = $yearMonth[0];

      return "{$year}/{$this->id}";
  }

  /**
   * Get request date hijri
   *
   * @return string
   */
  public function getHijriDateAttribute()
  {
    return CarbonHijri::toHijriFromMiladi($this->created_at);
  }
}
