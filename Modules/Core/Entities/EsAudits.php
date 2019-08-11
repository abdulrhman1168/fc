<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class EsAudits extends Model
{
    protected $fillable = [];

    public function user(){
        return $this->belongsTo('Modules\Auth\Entities\Core\User','user_id','user_id');
      }

}
