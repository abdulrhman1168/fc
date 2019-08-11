<?php
namespace Modules\Core\Entities\Core;

use Illuminate\Database\Eloquent\Model;
use Modules\NetworkPhone\Entities\DepartmentDomain;
use Modules\Core\Scopes\ActiveDepartment;
use Modules\Employees\Entities\Employee;
use Modules\Core\Entities\Core\Employee as CoreEmployee;

class HRDepartment extends Model
{

    use \Modules\Core\Traits\SharedModel;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hr_departments';

    public static $types = [
        'deanship' => 1,
        'collage' => 2,
        'department' => 3,
        'section' => 7
    ];

    /**
     * Get parent
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get children
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
                     ->where('parent_id', $this->id);
    }

    /**
     * Scope a query to collages.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCollages($query)
    {
        return $query->where('type', self::$types['collage']);
    }

     /**
     * Scope a query to departments with main types
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMainTypes($query)
    {
        return $query->whereIn('type', [1,2,3,6])
                     ->where('is_employee_appointment', 1);
    }

    public function maleManager()
    {
        return $this->belongsTo(CoreEmployee::class, 'direct_manager_m_id', 'employee_id');
    }

    public function femaleManager()
    {
        return $this->belongsTo(CoreEmployee::class, 'direct_manager_f_id', 'employee_id');
    }


    /**
     * Scope a query to collages.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasEmployees($query)
    {
        return $query->where('is_employee_appointment', 1);
    }

    /**
     * Get collage scientific sections
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scientificSections()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
                    ->where('parent_id', $this->id)
                    ->where('type', self::$types['section']);
    }

    public function networkPhoneDomains()
    {
        return $this->hasMany(DepartmentDomain::class, 'department_id', 'id');
    }

    /**
     * Get Main departments
     */
    public function mainDepartments($parent_id = 1)
    {
        return self::find($parent_id)->children();
    }

    // /**
    //  * The "booting" method of the model.
    //  *
    //  * @return void
    //  */
    // protected static function boot()
    // {
    //     parent::boot();
    //
    //     static::addGlobalScope(New ActiveDepartment);
    // }

    public function getMangerName($sex = 'm')
    {
        $mangerID = $this->direct_manager_m_id;

        if($sex == 'f') {
            $mangerID = $this->direct_manager_f_id;

            if(intval($mangerID) == 0) {
                $mangerID = $this->direct_manager_m_id;
            }
        }
        
        return CoreEmployee::where('employee_id', '=', $mangerID)->first()->arabic_name;
    }


    public function mangerData($sex = 'm')
    {
        if($sex == 'm') {
            return CoreEmployee::where('employee_id', '=', $this->direct_manager_m_id)->first();
        }
        else {
            return CoreEmployee::where('employee_id', '=', $this->direct_manager_f_id)->first();
        }
    }
    
    
    public function isDepartmentManager($user)
    {
        $empId = $user->employeeObject->employee_id;

        return in_array($empId, [$this->direct_manager_m_id, $this->direct_manager_f_id]); 
    }

    /**
     * Get a array  the id department and  all the id children
     */
    public function childsId($deptCodes = [1])
    {
        $deptCodes = !is_array($deptCodes) ? [$deptCodes] : $deptCodes;
        $finalDeptCodes = $this->getAllChildsId($deptCodes);
        foreach($deptCodes as $deptCode) {
            if(in_array($deptCode, $finalDeptCodes)) {
                continue;
            }

            $finalDeptCodes[] = $deptCode;
        }
        return $finalDeptCodes;
    }

    /**
     * Get a array the  all the id children
     */

    public function getAllChildsId($deptCodes = [1])
    {
        $allchildsId = []; 
        $getChildsForParent = self::whereIn('parent_id' , $deptCodes)->pluck('id')->toArray();
        if(count($getChildsForParent) > 0) {
            foreach ($getChildsForParent as $key => $value) {
                $getChilds = $this->getAllChildsId([$value]);
                $allchildsId = array_merge($allchildsId, $getChilds);
            }
            $allchildsId = array_merge($allchildsId, $getChildsForParent);
        }
        return $allchildsId;
    }
}