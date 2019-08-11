<?php

namespace Modules\DepartmentServices\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\UserBaseController;
use Validator;

// Entities
use Modules\MyServices\Entities\Attendance\EmployeeAttendanceTasks;
use Modules\MyServices\Entities\Attendance\Status;
use Modules\Core\Entities\Core\HRDepartment;

class TasksController extends UserBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $employeeAttendanceWaitingTasks = EmployeeAttendanceTasks::where([
                                            ['task_checker_id', auth()->user()->employeeObject->employee_id],
                                            ['task_status', 0]
                                        ])
                                        ->orWhere([
                                            ['task_confirmer_id', auth()->user()->employeeObject->employee_id],
                                            ['task_status', 1]
                                        ])
                                        ->with('taskStatus', 'employeeData')
                                        ->orderBy('id')
                                        ->get();

        if($this->isApiCall) {
            $data = [
                'waiting_tasks' => $employeeAttendanceWaitingTasks,
            ];

            return response()->json($data);
        }

        return view('departmentservices::attendance.tasks.index', compact('employeeAttendanceWaitingTasks'));
    }

    /**
     * update task by id
     * @return Response
     */
    public function updateTask(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'status'        => 'required|in:1,2',
            'reject_reason' => 'required_if:status,==,2',
        ]);

        if ($this->isApiCall) {
            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }
        } else {
            $validatedData->validate();
        }

        $taskData = EmployeeAttendanceTasks::findOrFail($request->task_id);

        if(!in_array($taskData->task_status, [0, 1])) {
            return response()->json('unauthorized acces', 422);
        }

        if($taskData->task_status == 0 && $taskData->task_checker_id != auth()->user()->employeeObject->employee_id) {
            return response()->json('unauthorized acces', 422);
        }

        if($taskData->task_status == 1 && $taskData->task_confirmer_id != auth()->user()->employeeObject->employee_id) {
            return response()->json('unauthorized acces', 422);
        }

        if($request->status == 1) {
            $taskData->task_status = $taskData->task_checker_id == auth()->user()->employeeObject->employee_id ? 1 : 2;
        }
        else {
            $taskData->task_status        = $taskData->task_checker_id == auth()->user()->employeeObject->employee_id ? 3 : 4;
            $taskData->task_reject_reason = $request->reject_reason;
        }

        $taskData->save();

        return response()->json('updated', 200);
    }

}
