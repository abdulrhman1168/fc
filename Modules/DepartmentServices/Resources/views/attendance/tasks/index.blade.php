@extends('layouts.main.index')

@section('page')

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light bordered">

                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject sbold"> {{ __('myservices::tasks.waiting_tasks') }}</span>
                    </div>

                    <div class="actions">
                    </div>
                </div>

                <div class="panel-body">
                    
                    <table class="table table-striped panel-body">
                        <thead>
                            <tr>
                                <th>{{ __('myservices::tasks.employee_name') }}</th>
                                <th>{{ __('myservices::tasks.task_date') }}</th>
                                <th>{{ __('myservices::tasks.task_days') }}</th>
                                <th>{{ __('myservices::tasks.task_type') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($employeeAttendanceWaitingTasks as $task)
                                <tr id="waiting_tasks_row_{{ $task->id }}">
                                    <td>{{ (App::getLocale() == 'ar') ? $task->employeeData->arabic_name : $task->employeeData->english_name }}</td>
                                    <td>{{ $task->task_from_date_hijri }} - {{ $task->task_to_date_hijri }}</td>
                                    <td>{{ $task->real_days }}</td>
                                    <td>{{ $task->taskStatus->name }}</td>
                                    <td>
                                        <button 
                                            type="button"
                                            class="btn default task-info-btn"
                                            data-id="{{ $task->id }}"
                                            data-employee-name="{{ (App::getLocale() == 'ar') ? $task->employeeData->arabic_name : $task->employeeData->english_name }}"
                                            data-task-title="{{ $task->task_title }}"
                                            data-task-date="{{ $task->task_from_date_hijri }} - {{ $task->task_to_date_hijri }}"
                                            data-task-type="{{ $task->taskStatus->name }}"
                                            data-task-note="{{ $task->task_note }}"
                                            data-task-real-days="{{ $task->real_days }}"
                                            title="{{ __('myservices::tasks.tasks_info') }}"
                                        >
                                            <i class="fa fa-info" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn green accept-confirmation" data-id="{{ $task->id }}" title="{{ __('myservices::tasks.tasks_accept_btn') }}"><i class="fa fa-check" aria-hidden="true"></i></button>
                                        <button type="button" class="btn red reject-confirmation" data-id="{{ $task->id }}" title="{{ __('myservices::tasks.tasks_reject_btn') }}"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                            @if($employeeAttendanceWaitingTasks->count() == 0)

                                <tr>
                                    <td colspan="5"><center>{{ __('myservices::tasks.waiting_tasks_empty') }}</center></td>
                                </tr>

                            @endif
                                   
                        </tbody>
                    </table>

                </div>
                    
            
            </div>

        </div>

    </div>

    <div class="modal fade bs-modal-lg" id="task-information-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ __('myservices::tasks.tasks_info') }}</h4>
                </div>
            
                <div class="modal-body">
                    <table class="table table-striped panel-body">
                        <tbody>
                            <tr>
                                <td>{{ __('myservices::tasks.employee_name') }}:</td>
                                <td id="employee_name"></td>
                            </tr>
                            <tr>
                                <td>{{ __('myservices::tasks.task_title') }}:</td>
                                <td id="task_title"></td>
                            </tr>
                            <tr>
                                <td>{{ __('myservices::tasks.task_date') }}:</td>
                                <td id="task_date"></td>
                            </tr>
                            <tr>
                                <td>{{ __('myservices::tasks.task_type') }}:</td>
                                <td id="task_type"></td>
                            </tr>
                            <tr>
                                <td>{{ __('myservices::tasks.task_real_days') }}:</td>
                                <td id="task_real_days"></td>
                            </tr>
                            <tr>
                                <td>{{ __('myservices::tasks.task_note') }}:</td>
                                <td id="task_note"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn green accept-confirmation" id="modal-accept-btn" data-id="0" title="{{ __('myservices::tasks.tasks_accept_btn') }}"><i class="fa fa-check" aria-hidden="true"></i></button>
                    <button type="button" class="btn red reject-confirmation" id="modal-reject-btn" data-id="0" title="{{ __('myservices::tasks.tasks_reject_btn') }}"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{ __('myservices::tasks.tasks_cancel_btn') }}</button>
                </div>
            
            </div>
        </div>
    </div>

    <div class="modal fade" id="reject-form" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                {!! Form::open(['id' => 'form_reject_task']) !!}

                    {!! Form::hidden('task_id', null, ['id' => 'task_id', 'class' => 'form-control']) !!}
                    
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">{{ __('myservices::tasks.task_reject_reason') }}</h4>
                    </div>
                
                    <div class="modal-body">
                        {!! Form::textarea('reject_reason', null, ['id' => 'reject_reason', 'class' => 'form-control', 'rows' => '3', 'placeholder' => __('departmentservices::permissions.reject_reason'), 'required' => 'true']) !!}
                    </div>
    
                    <div class="modal-footer">
                            {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i> ' . __('myservices::tasks.tasks_send_btn'), ['type' => 'submit', 'class' => 'btn green-haze']) !!}
                            {!! Form::button('<i class="fa fa-times" aria-hidden="true"></i> ' . __('myservices::tasks.tasks_back_btn'), ['type' => 'button', 'class' => 'btn dark btn-outline', 'data-dismiss' => 'modal']) !!}
                    </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>

@endsection



@section('scripts_2')

    {!! Html::script('assets/js/sweetalert.min.js') !!}

    <script>
        $(".task-info-btn").click(function() {
            $('#task-information-modal #employee_name').text($(this).attr('data-employee-name'));
            $('#task-information-modal #task_title').text($(this).attr('data-task-title'));
            $('#task-information-modal #task_date').text($(this).attr('data-task-date'));
            $('#task-information-modal #task_type').text($(this).attr('data-task-type'));
            $('#task-information-modal #task_real_days').text($(this).attr('data-task-real-days'));
            $('#task-information-modal #task_note').text($(this).attr('data-task-note'));
            $('#task-information-modal #modal-accept-btn').attr('data-id', $(this).attr('data-id'));
            $('#task-information-modal #modal-reject-btn').attr('data-id', $(this).attr('data-id'));

            $('#task-information-modal').modal('show');
        });

        $('.accept-confirmation').click(function() {
            $('#task-information-modal').modal('hide');
            swal({
                text: "{{ __('myservices::tasks.tasks_alert_accept_confirmation') }}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: [
                    "{{ __('myservices::tasks.tasks_no_btn') }}",
                    "{{ __('myservices::tasks.tasks_yes_btn') }}"
                ],
            })
            .then((isConfirmed) => {
    
                if(isConfirmed) {
                    var taskID = $(this).attr('data-id');
    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
    
                    $.ajax({
                        type: 'put',
                        url: '/department-services/attendance/tasks/' + taskID + '/update',
                        data: { 'status': 1 },
                        success: function(){
                            $('#waiting_tasks_row_' + taskID).remove();
                        }
                    });
                }
    
            });
        });

        $('.reject-confirmation').click(function() {
            $('#task-information-modal').modal('hide');
            $("#task_id").val($(this).data('id'));

            $("#reject_reason").val("");
            $('#reject-form').modal('show');
        });

        $('form#form_reject_task').on('submit', function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var taskID          = $('form#form_reject_task #task_id').val();
            var rejectReason    = $('form#form_reject_task #reject_reason').val();

            $.ajax({
                type: 'put',
                url: '/department-services/attendance/tasks/' + taskID + '/update',
                data: { 'status': 2, 'reject_reason': rejectReason },
                success: function(){
                    $('#waiting_tasks_row_' + taskID).remove();
                }
            });

            $('#reject-form').modal('hide');

        });
    </script>

@endsection