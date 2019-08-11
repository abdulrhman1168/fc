@extends('layouts.main.index')

@section('page')
    <div class="row">

        <div class="portlet light bordered">
            
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users"></i>
                    <span class="caption-subject sbold uppercase">البحث</span>
                </div>
                <div class="actions">
                </div>
            </div>

            <div class="panel-body">
                
                {!! Form::open(['method' => 'GET']) !!}

                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('department_id', 'الإدارة', ['class' => 'control-label col-md-1']) !!}
                            <div class="col-md-3">
                                {{ Form::select('department_id[]', $departmentsData, NULL, ['class' => 'form-control select2', 'multiple' => 'multiple']) }}
                            </div>
                            
                            {!! Form::label('employee_id', 'الموظف', ['class' => 'control-label col-md-1']) !!}
                            <div class="col-md-3">
                                {{ Form::select('employee_id[]', $employeesData, NULL, ['class' => 'form-control select2', 'multiple' => 'multiple']) }}
                            </div>
                            
                            {!! Form::label('attendance_status', 'الحالة', ['class' => 'control-label col-md-1']) !!}
                            <div class="col-md-3">
                                {{ Form::select('attendance_status[]', $attendanceStatuses, NULL, ['class' => 'form-control select2', 'multiple' => 'multiple']) }}
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="form-group">
                            {!! Form::label('start_date', 'تاريخ البداية', ['class' => 'control-label col-md-1']) !!}
                            <div class="col-md-3">
                                {{ Form::text('start_date', old('start_date') ?: date('Y-m-d'), ['class' => 'form-control en-datepicker-input']) }}
                            </div>

                            {!! Form::label('end_date', 'تاريخ النهاية', ['class' => 'control-label col-md-1']) !!}
                            <div class="col-md-3">
                                {{ Form::text('end_date', old('end_date') ?: date('Y-m-d'), ['class' => 'form-control en-datepicker-input']) }}
                            </div>

                            <div class="col-md-1">
                            </div>

                            <div class="col-md-3">
                                {!! Form::button('بحث', ['type' => 'submit', 'class' => 'btn btn-sm blue col-md-12']) !!}
                            </div>
                        </div>
                    </div>

                {!! Form::close() !!}
            
            </div>

        </div>


        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users"></i>
                    <span class="caption-subject sbold uppercase">حضور وإنصراف الموظفين</span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>الرقم الوظيفي</th>
                            <th>إسم الموظف</th>
                            <th>الإدارة</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>توقيت الدخول</th>
                            <th>توقيت الخروج</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employeesAttendance as $attendance)
                        <tr>
                            <td>{{ $attendance->employee_job_no }}</td>
                            <td>{{ $attendance->arabic_name }}</td>
                            <td>{{ $attendance->department_name }}</td>
                            <td>{{ $attendance->status_name }}</td>
                            <td>{{ $attendance->sign_date->format('Y-m-d') }}</td>
                            <td>{{ $attendance->checkin }}</td>
                            <td>{{ $attendance->checkout }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {!! $employeesAttendance->appends(request()->query())->links() !!}

            </div>
        </div>

    </div>
@endsection


@section('scripts_2')
    <script>
        $(".select2").select2();
    </script>
@endsection