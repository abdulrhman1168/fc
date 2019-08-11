<?php
namespace Modules\Core\Entities\Core;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Core\User;
use Modules\Core\Entities\Core\Permission;
use Modules\Core\Entities\Core\Employee;
use Modules\Core\Entities\Core\HRDepartment;
use Modules\ClearanceForm\Entities\ClearanceForm;
use DB;


class Group extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'es_core_groups';

  /**
   * The attributes that are mass assignable
   *
   * @var array
   */
  protected $fillable = ['parent_id', 'name', 'name_en', 'key'];

  /**
   * unified groups keys
   *
   * @var array
   */
  public static $unifiedGroups = [
    'university' => 'es_university_group',
    'govern_employees' => 'es_university_govern_employees_group',
    'direct_managers' => 'es_univeristy_direct_managers',
    'parent_managers' => 'es_univeristy_parent_managers',
    'es_management_and_financial_group' => 'es_management_and_financial_group',
    'parent_managers_and_deans_who_dont_have_emps' => 'parent_managers_and_deans_who_dont_have_emps',
    'clearance_form_group' => 'clearance_form_group',
  ];


 /**
  * Get permissions specified for group
  */
 public function permissions()
 {
   return $this->morphMany(Permission::class, 'permissionable');
 }

 /**
  * Get group users
  */
 public function users()
 {
   return $this->belongsToMany(User::class, 'es_core_users_groups', 'es_core_group_id', 'user_id');
 }

 /**
  * Return Table Name
  */
  public static function table()
  {
      return with(new static)->getTable();
  }

  public static function findByKey($key)
  {
    return self::where('key', '=' ,$key)->first();
  }

  public static function findUnifiedGroupByName($name)
  {
    return self::findByKey(self::$unifiedGroups[$name]);
  }

  public static function syncUniveristyGroup()
  {
      // $usersIds = User::on('oracle')->pluck('user_id')->toArray();
      $usersIds = User::on('oracle')->whereNotIn('user_id', ClearanceForm::usersIDs())->pluck('user_id')->toArray();
      $group = self::findUnifiedGroupByName('university');
      $group->users()->sync($usersIds);
  }

  public static function syncGovernEmployeesGroup()
  {
        // $employeesNationalIds = Employee::pluck('national_id')->toArray();
        $employeesNationalIds = Employee::whereNotIn('national_id', ClearanceForm::nationalIDs())->pluck('national_id')->toArray();
        $idsArrayChunks = array_chunk($employeesNationalIds, 900);


        $governUsersIds = User::on('oracle')
                              ->whereIn('user_idno', $idsArrayChunks[0]);

        for ($x = 1; $x < count($idsArrayChunks); $x++) {
            $governUsersIds->orWhereIn('user_idno', $idsArrayChunks[$x]);
        }


        $governUsersIds = $governUsersIds->pluck('user_id')->toArray();
        $governGroup = self::findUnifiedGroupByName('govern_employees');
        $governGroup->users()->sync($governUsersIds);
  }

  public static function syncManagersGroup($type)
  {
    $joinDept = null;
    $groupName = null;

    if ($type == "direct") {
      $joinDept = Employee::table().'.dept_code';
      $groupName = 'direct_managers';
    } else if ($type == "parent") {
      $joinDept = Employee::table().'.real_dept_code';
      $groupName = 'parent_managers';
    }

    $depts =  HRDepartment::join(Employee::table(), HRDepartment::table().'.id', $joinDept)
                               ->select(
                                 HRDepartment::table().'.id As dept_id',
                                 HRDepartment::table().'.direct_manager_m_id As male_manager_id',
                                 HRDepartment::table().'.direct_manager_f_id As female_manager_id'
                                 )
                               ->distinct('dept_id')
                               ->get();

    $directManagersIds = [];

    foreach($depts as $dept) {
      if ($dept->male_manager_id != null && !in_array($dept->male_manager_id, ClearanceForm::employeeIDs()) ) {
        $directManagersIds[] = $dept->male_manager_id;
      }
      if ($dept->female_manager_id != null && !in_array($dept->female_manager_id, ClearanceForm::employeeIDs()) ) {
        $directManagersIds[] = $dept->female_manager_id;
      }
    }

    $employeeNationalIds = Employee::whereIn('employee_id', $directManagersIds)
                                   ->select('national_id')->get()
                                   ->pluck('national_id')
                                   ->toArray();

    $usersIds = User::whereIn('user_idno', $employeeNationalIds)
                    ->get()->pluck('user_id')->toArray();

    $group = self::findUnifiedGroupByName($groupName);
    $group->users()->sync($usersIds);
  }

  public static function syncManagersNoEmployeeGroup()
  {

    $allDirectManagersDepts = Employee::select('dept_code')->distinct()->pluck('dept_code')->toArray();
    $allParentManagersDepts = Employee::select('real_dept_code')->distinct()->pluck('real_dept_code')->toArray();
    $allManagersDepts = array_merge($allDirectManagersDepts, $allParentManagersDepts);
    
    $depts = HRDepartment::whereNotIn('id', $allManagersDepts)->get();

    

    $groupName = 'parent_managers_and_deans_who_dont_have_emps';


    $directManagersIds = [];

    foreach($depts as $dept) {
      if ($dept->direct_manager_m_id != null && !in_array($dept->direct_manager_m_id, ClearanceForm::employeeIDs()) ) {
        $directManagersIds[] = $dept->direct_manager_m_id;
      }
      if ($dept->direct_manager_f_id != null && !in_array($dept->direct_manager_f_id, ClearanceForm::employeeIDs()) ) {
        $directManagersIds[] = $dept->direct_manager_f_id;
      }
    }

    $employeeNationalIds = Employee::whereIn('employee_id', $directManagersIds)
                                   ->select('national_id')->get()
                                   ->pluck('national_id')
                                   ->toArray();

    $usersIds = User::whereIn('user_idno', $employeeNationalIds)
                    ->get()->pluck('user_id')->toArray();

    $group = self::findUnifiedGroupByName($groupName);
    $group->users()->sync($usersIds);
  }

  public static function syncClearanceFormGroup()
  {      
      $usersIds = ClearanceForm::usersIDs();
      $group = self::findUnifiedGroupByName('clearance_form_group');

      Permission::whereIn('permissionable_id', $usersIds)->where('permissionable_type', '<>', 'Modules\Core\Entities\Core\Group')->delete();
      \DB::table('es_core_users_groups')->whereIn('user_id', $usersIds)->where('es_core_group_id', '<>', $group->id)->delete();

      $group->users()->sync($usersIds);
  }

  public static function syncUsersUnifiedGroups()
  {
      self::syncUniveristyGroup();
      self::syncGovernEmployeesGroup();
      self::syncManagersGroup('direct');
      self::syncManagersGroup('parent');
      self::syncManagersNoEmployeeGroup();
      self::syncClearanceFormGroup();
  }

  public static function hasUserByKey($key, $user)
  {
    $group = self::findByKey($key);

    return $group->hasUser($user);
  }

  public function hasUser($user)
  {
    $user = $this->users()
                  ->where(User::table().'.user_id', '=', $user->user_id)
                  ->first();

    return ($user == null ? false : true);
  }
}