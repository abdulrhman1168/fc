<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WsInfo extends Model
{
  protected $table = 'mu_websites.ws_info';

  protected $connection = 'mysql';

  protected $primaryKey = 'info_email';

}
