<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Core\Entities\Core\Employee as EmployeeView;
use Modules\Employees\Entities\Employee as EmployeeTable;
use Modules\Core\Entities\Core\HRDepartment;

/*
    This job is used for sync data from hr_employee view to employees table :)
*/

class UpdateEmployeesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a New job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $hr_employees = EmployeeView::on('oracle')
                                    ->leftjoin(HRDepartment::table(), HRDepartment::table().'.id', EmployeeView::table().'.real_dept_code')
                                    ->where(EmployeeView::table().'.emp_status', '!=', '5')
                                    ->whereNotNull(EmployeeView::table().'.national_id')
                                    ->select(EmployeeView::table().'.*', HRDepartment::table().'.parent_id')
                                    ->get();

        foreach ($hr_employees as $employee) {

            $real_dept_code = $employee->real_dept_code;
            $dept_code      = $employee->dept_code;
            $internal_dept  = NULL;

            // trying to get the real dept code, ept_code & internal_dept
            // if($employee->parent_id != NULL) {
            //     $internal_dept  = $dept_code;
            //     $dept_code      = $real_dept_code;
            //     $real_dept_code = $employee->parent_id;
            // }

            if($employee->parent_id != NULL) {
                $internal_dept  = $dept_code;
                $dept_code      = $dept_code;
                $real_dept_code = $real_dept_code;
            }

            $data = [
                'employee_id'            => $employee->employee_id,
                'arabic_name'            => $employee->arabic_name,
                'english_name'           => $employee->english_name,
                'national_id'            => trim($employee->national_id),
                'gender'                 => $employee->gender,
                'gender_desc'            => $employee->gender_desc,
                'g_birth_date'           => $employee->g_birth_date,
                'h_birth_date'           => $employee->h_birth_date,
                'nationality'            => $employee->nationality,
                'issaudi'                => $employee->issaudi,
                'email'                  => $employee->email,
                'mobile_no'              => $employee->mobile_no,
                'phone_no'               => $employee->phone_no,
                'address'                => $employee->address,
                'g_service_start_date'   => $employee->g_ervice_start_date,
                'h_service_start_date'   => $employee->h_service_start_date,
                'g_assignment_date'      => $employee->g_assignment_date,
                'h_assignment_date'      => $employee->h_assignment_date,
                'g_join_date'            => $employee->g_join_date,
                'h_join_date'            => $employee->h_join_date,
                'g_last_promotion_date'  => $employee->g_last_promotion_date,
                'h_last_promotion_date'  => $employee->h_last_promotion_date,
                'real_dept_code'         => $real_dept_code,
                'dept_code'              => $dept_code,
                'internal_dept'          => $internal_dept,
                'actual_dept_code_desc'  => $employee->actual_dept_code_desc,
                'form_code'              => $employee->form_code,
                'form_desc'              => $employee->form_desc,
                'scale_id'               => $employee->scale_id,
                'scale_desc'             => $employee->scale_desc,
                'job_no'                 => $employee->job_no,
                'job_desc'               => $employee->job_desc,
                'rank_code'              => $employee->rank_code,
                'rank_desc'              => $employee->rank_desc,
                'emp_status'             => $employee->emp_status,
                'emp_status_desc'        => $employee->emp_status_desc,
                'can_update'             => false,
                'is_government_employee' => 1,
            ];

            EmployeeTable::on('oracle')->updateOrCreate(['national_id' => $employee->national_id], $data);
        }

    }
}
