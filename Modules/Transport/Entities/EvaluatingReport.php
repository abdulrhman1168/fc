<?php

namespace Modules\Transport\Entities;
use Modules\Core\Entities\Core\HRDepartment;


use Illuminate\Database\Eloquent\Model;

class EvaluatingReport extends Model
{
    protected $table = "trans_evaluating_reports";
    protected $fillable = 
    ['id','supervisor_id','login_no','uploade_reports_no',
    'printed_reports_no','reports_from_system_no','daily_movement_uploaded',
    'supervision_unit','follow_unit','manager','computer_unit','status'
    ];

    public static function reportsWithSupervisor()
    {
    $reports = EvaluatingReport::leftJoin('mu_users','mu_users.user_id', 'trans_evaluating_reports.supervisor_id')
                ->select('trans_evaluating_reports.*','mu_users.user_name as supervisor_name')
                ->get();
        return $reports;
    }
}
