<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'hr_department';
    protected $fillable = ['name_ar', 'parent_id', 'user_id'];

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }
}
