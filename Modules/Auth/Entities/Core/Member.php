<?php

namespace Modules\Auth\Entities\Core;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Modules\Core\Traits\AuthorizeUser;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\UserResolver;



   

class Member extends Model
{

   

    

    protected $table = 'members';

    /**
    * Set table primary key
    * @var string
    */
    protected $primaryKey = 'id';

    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
             "id",
             "name",
             "email",
             "mobile",
             "id_no",
            
           ];

    





    /**
     * Search for user by query token
     * @param $query token search
     * @return Collection users
     */
    public static function search($query)
    {
        return self::where('id', 'LIKE', '%'.$query.'%')
                  ->orWhere('name', 'LIKE', '%'.$query.'%')
                  ->orWhere('email', 'LIKE', '%'.$query.'%')
                  ->orWhere('mobile', 'LIKE', '%'.$query.'%')
                  ->orWhere('id_no', 'LIKE', '%'.$query.'%');
    }



}
