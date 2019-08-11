<?php
namespace Modules\DepartmentServices\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\SharedModel;

use Modules\Core\Entities\Core\HRDepartment;
use Modules\Core\Entities\Core\Employee;
use Auth;
class UpdateResearchs extends Model
{
    use SharedModel;

    /**
     * The table associated with the model.
     *
     * @var string
     */
   // protected $table      = 'es_permission_changes';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
   // protected $fillable   = ['employee_number', 'from_date', 'to_date', 'type_id', 'type_name', 'reason', 'organization_id', 'direct_manager_id', 'p_dept_code', 'status', 'reject_reason', 'previous_id', 'action_by', 'action_method'];
   public static function getData()
  {
    $updateResearchs      = [];
    $departments = HRDepartment::select('id')
    ->Where('direct_manager_m_id', '=' , Auth::user()->employee()->employee_id)->take(1)->get();
   // ->Where('is_employee_appointment', '=', 1)->get();
foreach ($departments as $department) {
$dept=   $department->id;
}

$updateResearchs = Employee::select('user_id','employee_id', 'arabic_name','rank_desc','user_idno','pladge', 'dept_code', 'parent_id')
      ->join('mu_users', 'national_id', '=', 'user_idno')
      ->join('hr_departments', 'dept_code', '=' , 'id')
      ->Where('pladge' , 1)
      ->Where('parent_id', '=' , $dept)
      ->get();
      return $updateResearchs;
  }
  
}
