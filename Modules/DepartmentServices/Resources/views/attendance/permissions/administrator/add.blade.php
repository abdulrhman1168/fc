@extends('layouts.main.index')

@section('page')
<div class="row">

    <div class="col-md-12">

        <div id="alert-success" class="custom-alerts alert alert-success fade in" @if(!Session::has('success')) style="display:none" @endif>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

            <i class="fa fa-check" aria-hidden="true"></i>
            <span id="message">{{ Session::get('success') }}</span>
        </div>

        <div id="alert-danger" class="custom-alerts alert alert-danger fade in" @if(!Session::has('error')) style="display:none" @endif>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

            <i class="fa fa-times" aria-hidden="true"></i>
            <span id="message">{{ Session::get('error') }}</span>
        </div>

        <div class="portlet light bordered">

            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-plus"></i>
                    <span class="caption-subject sbold uppercase">{{ __('departmentservices::permissions.add_permission') }}</span>
                </div>
                <div class="actions">
                    <a class="btn btn-danger" href="{{ route('permissions.administrator.display-all-permissions') }}"><i class="fa fa-chevron-left"></i></a>
                </div>
            </div>

            <div class="portlet-body form">
                
                {{ Form::open(['route' => 'permissions.administrator.store', 'method' => 'post']) }}

                    <div class="form-body">

                        <div class="form-group">
                            {{ Form::label('employee_number', __('departmentservices::permissions.employee_id')) }}
                            <div class="form-group">
                                {{ Form::text('employee_number', old('employee_number'), ['class' => 'form-control', 'id' => 'employee_number', 'required' => true]) }}
                                <b id="employee_number_reponse"></b>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('employee_name', __('departmentservices::permissions.employee_name')) }}
                            <div class="form-group">
                                {{ Form::text('employee_name', NULL, ['class' => 'form-control', 'id' => 'employee_name', 'disabled' => true]) }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('permission_date', __('myservices::permissions.request_date')) }}
                            <div class="form-group">
                                {{ Form::text('permission_date', NULL, ['class' => 'form-control en-datepicker-input', 'id' => 'permission_date', 'required' => true]) }}
                                <b id="permission_date_reponse"></b>

                                <div class="has-error">
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_date') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('permission_type', __('myservices::permissions.request_permission_type')) }}
                            <div class="form-group">
                                {!! Form::select('permission_type', $permission_type_name, NULL, ['id' => 'permission_type', 'class' => 'form-control select2', 'required' => true]) !!}

                                <div class="has-error">
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_type') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('permission_reason', __('myservices::permissions.request_permission_reason')) }}
                            <div class="form-group">
                                {!! Form::textarea('permission_reason', null, ['id' => 'permission_reason', 'class' => 'form-control', 'rows' => '2', 'required' => true]) !!}

                                <div class="has-error">
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_reason') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            {{ Form::label('permission_status', __('departmentservices::permissions.status')) }}
                            <div class="form-group">
                                {!! Form::select('permission_status', $permission_status, NULL, ['id' => 'permission_status', 'class' => 'form-control select2', 'required' => true]) !!}

                                <div class="has-error">
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_status') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div id="reject_reason_div" class="form-group" style="display: none">
                            {{ Form::label('reject_reason', __('departmentservices::permissions.reject_reason') ) }}
                            <div class="form-group">
                                {!! Form::textarea('reject_reason', null, ['id' => 'reject_reason', 'class' => 'form-control', 'rows' => '2']) !!}

                                <div class="has-error">
                                    <span class="help-block">
                                        <strong>{{ $errors->first('reject_reason') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i> ' . __('departmentservices::permissions.save_btn'), ['id' => 'save_btn', 'type' => 'submit', 'class' => 'btn green-haze']) !!}
                        </div>

                    </div>

                {{ Form::close() }}
            </div>



        </div>

    </div>
</div>

@endsection


@section('scripts_2')
    {{ Html::script('https://unpkg.com/axios/dist/axios.min.js') }}

    <script>
        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

        $("#employee_number").focusin(function() {
            $("#employee_number_reponse").text('');
        });

        $("#employee_number").focusout(function() {
            $("#employee_number_reponse").text('يرجى الإنتظار .. ');

            var employeeNumber = $("#employee_number").val();
            var permissionDate = $('#permission_date').val();
            if(employeeNumber == '') {
                $("#employee_number_reponse").text('رقم الموظف مطلوب');
                return false;
            }

            axios.post('/department-services/attendance/permissions/administrator/employee-info', { employee_number: employeeNumber })
            .then(function (response) {
                $("#employee_name").val(response.data);
                $("#employee_number_reponse").text('');
            })
            .catch(function (error) {
                $("#employee_number_reponse").text('الموظف غير موجود');
            });
        });


        $('#permission_status').change(function() {
            if($(this).val() == 2) {
                $("#reject_reason_div").show();
            }
            else {
                $("#reject_reason_div").hide();
            }
        });
    </script>

@endsection
