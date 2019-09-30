<?php

namespace Modules\Auth\Entities\Core;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Auth\Traits\UserAuth;
use Modules\Core\Entities\Core\Employee;
use Modules\Core\Entities\Core\Group;
use Modules\Core\Entities\Core\Permission;
use Modules\Core\Traits\AuthorizeUser;
use Modules\MobileApp\Entities\PushToken;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\UserResolver;
use Auth;
use Laravel\Passport\HasApiTokens;

use App;

class User extends Authenticatable  implements Auditable, UserResolver
{
    use Notifiable, UserAuth, AuthorizeUser,
       \Modules\Core\Traits\SharedModel,
       \OwenIt\Auditing\Auditable,
       HasApiTokens;

     /**
     * {@inheritdoc}
     */
    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }

    public $timestamps = false;
    /**
      * The table associated with the model.
      *
      * @var string
      */

    protected $table = 'mu_users';

    /**
    * Set table primary key
    * @var string
    */
    protected $primaryKey = 'user_id';

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
             "user_id",
             "user_idno",
             "user_empno",
             "user_dept",
             "user_level",
             "user_title",
             "user_name",
             "user_enname",
             "user_desc",
             "user_password",
             "user_mail",
             "user_mobile",
             "user_sex",
             "created_at",
             "updated_at",
             "deleted_at",
             "group_id",
             "is_super_admin",
             "user_dept2",
             "user_dept3",
             "user_type",
             "user_group",
             "user_altmail",
             "user_ext",
             "user_phone",
             "user_nat",
             "user_lang",
             "user_city",
             "user_building",
             "user_room",
             "user_flag",
             "user_approved",
             "user_indaleel",
             "user_joined",
             "user_device",
             "user_ration",
             "user_fax",
             "user_task",
             "user_task2",
             "flag",
             "user_course_upload",
             "user_task_upload",
             "user_has_task",
             "user_doctor",
             "section",
             "menu_status"
           ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function employee()
    {
        return Employee::where('user_idno', $this->user_idno)
                       ->first();
    }

    public function employeeObject() {
      return $this->belongsTo(Employee::class, 'user_idno', 'user_idno')
                  ->where('user_idno', $this->user_idno);
    }

    /**
    * Get permissions specified for user only
    */
    public function permissions()
    {
        return $this->morphMany(Permission::class, 'permissionable');
    }

    /**
    * Get user groups
    */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'es_core_users_groups', 'user_id', 'es_core_group_id');
    }
    public function checkInGroup($key = null)
    {
        return $this->groups()->where('key', '=', $key)->exists();
    }

    /**
     * Search for user by query token
     * @param $query token search
     * @return Collection users
     */
    public static function search($query)
    {
        return self::where('user_name', 'LIKE', '%'.$query.'%')
                  ->orWhere('user_enname', 'LIKE', '%'.$query.'%')
                  ->orWhere('user_mail', 'LIKE', '%'.$query.'%')
                  ->orWhere('user_mobile', 'LIKE', '%'.$query.'%')
                  ->orWhere('user_idno', 'LIKE', '%'.$query.'%');
    }

    /**
     * Get Current User Departemnt
     * @return user HR department
     */
     public function department()
     {
       return optional($this->employeeObject)->department;
     }

     /**
     * Get Main Department
     * @return user HR department
     */
    public function mainDepartment()
    {
      return optional($this->employeeObject)->department;
    }

     public static function findByIdNo($user_idno)
     {
       return self::where('user_idno', $user_idno)->first();
     }


     /**
     * Get user news
     */
     public function news()
     {
         return $this->hasMany('Modules\News\Entities\TawasolNews', 'news_created_by', 'user_id');
     }

     /**
     * Get user info from employee table
     */
     public function employeeTable()
     {
         return $this->hasOne('Modules\Employees\Entities\Employee', 'national_id', 'user_idno');
     }


    public function getIsGovEmployeeAttribute()
    {
        return $this->groups()
                    ->where('key', Group::$unifiedGroups['govern_employees'])
                    ->count() > 0;
    }

    public function getdisplayGovServicesAttribute()
    {
        return $this->isGovEmployee || $this->is_super_admin;
    }

    public static function syncFromMysql()
    {
        $users = User::on('mysql')->get();
        
        foreach ($users as $user) {
            $mail = explode("@", $user->user_mail);

            $data = [
                'user_idno' => $user->user_idno,
                'user_empno' => $user->user_empno,
                'user_dept' => $user->user_dept,
                'user_level' => $user->user_level,
                'user_title' => $user->user_title,
                'user_name' => $user->user_name,
                'user_enname' => $user->user_enname,
                'user_desc' => $user->user_desc,
                'user_password' => md5($mail[0]),
                'user_mail' => $user->user_mail,
                'user_mobile' => $user->user_mobile,
                'user_sex' => $user->user_sex,
                'group_id' => $user->group_id,
                'user_dept2' => $user->user_dept2,
                'user_dept3' => $user->user_dept3,
                'user_type' => $user->user_type,
                'user_group' => $user->user_group,
                'user_altmail' => $user->user_altmail,
                'user_ext' => $user->user_ext,
                'user_phone' => $user->user_phone,
                'user_nat' => $user->user_nat,
                'user_lang' => $user->user_lang,
                'user_city' => $user->user_city,
                'user_building' => $user->user_building,
                'user_room' => $user->user_room,
                'user_flag' => $user->user_flag,
                'user_approved' => $user->user_approved,
                'user_indaleel' => $user->user_indaleel,
                'user_joined' => $user->user_joined,
                'user_device' => $user->user_device,
                'user_activation' => $user->user_activation,
                'user_fax' => $user->user_fax,
                'user_task' => $user->user_task,
                'user_task2' => $user->user_task2,
                'flag' => $user->flag,
                'user_has_task' => $user->user_has_task,
                'user_doctor' => $user->user_doctor,
            ];

            if ($user->user_mail == 'eservices@mu.edu.sa') {
                $data['user_password'] = md5('Eservices@12sw');
            }

            // if ($user->is_super_admin == 1) {
            //     $data['user_password'] = md5($user->user_mobile);
            // }

            if ($user->user_idno != null && $user->user_mobile != null) {
              User::on('oracle')->updateOrCreate(['user_id' => $user->user_id], $data);
            }
        }
    }

    public function isMemberOfGroup($groupKey)
    {
        return Group::hasUserByKey($groupKey, $this);
    }

    public  function employeeToken() {
        return $this->hasMany('Modules\MobileApp\Entities\PushToken', 'user_id', 'user_id');
      }

}
