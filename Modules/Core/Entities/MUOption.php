<?php

namespace Modules\Core\Entities\Core;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Core\User;

class MUOption extends Model
{

    /**
     * The table database connection
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mu_db.options';
}
