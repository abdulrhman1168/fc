<?php
namespace Modules\DepartmentServices\Entities\Attendance;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\SharedModel;

use Modules\Core\Entities\Core\Employee;

class PermissionChanges extends Model
{
    use SharedModel;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table      = 'es_permission_changes';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable   = ['employee_number', 'from_date', 'to_date', 'type_id', 'type_name', 'reason', 'organization_id', 'direct_manager_id', 'p_dept_code', 'status', 'reject_reason', 'previous_id', 'action_by', 'action_method'];
}
