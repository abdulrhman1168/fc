<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'trans_permission';
    protected $fillable = ['user_id','perm_id'];
}
