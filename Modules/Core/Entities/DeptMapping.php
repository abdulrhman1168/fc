<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\Core\HRDepartment;

class DeptMapping extends Model
{
    protected $table = 'hr_departments_mapping';
    protected $fillable = ['hr_departments','mu_departments'];

    public function hr()
    {
        return $this->hasOne(HRDepartment::class,'id','hr_departments');
    }
}
