<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['path','model_id','original_name','model','created_at','updated_at'];
    protected $table = 'trans_files';
}
