<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

class MuBuilding extends Model
{
    protected $fillable = ['id_city','name','name_en'];
    public function city(){
        return $this->belongsTo('Modules\Core\Entities\TrCities','id_city','id');
      }
}
