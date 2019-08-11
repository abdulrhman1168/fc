<?php

namespace Modules\Transport\Entities;

use Illuminate\Database\Eloquent\Model;

class SMSMessage extends Model
{
    protected $table = 'trans_SMSMessage';
    protected $fillable = ['driver','track','receiver_status','content','send_status','hijridate'];

}
