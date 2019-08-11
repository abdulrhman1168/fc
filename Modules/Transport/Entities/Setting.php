<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'trans_setting';
    protected $fillable = ['start_date','end_date','year'];

}
