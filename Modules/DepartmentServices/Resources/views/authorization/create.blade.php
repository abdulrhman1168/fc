@extends('layouts.main.index')

@section('page')

    <div class="row">
        <div class="col-md-12">

            @if(session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @endif

            <div class="portlet light bordered form-fit">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-plus" aria-hidden="true"></i> انشاء تفويض جديد
                    </div>

                    <div class="actions">
                    </div>
                </div>
                
                <div class="portlet-body form">

                    {!! Form::open(['route' => 'authorization.store', 'method' => 'POST']) !!}
                        <div class="form-horizontal form-bordered">
                            
                            <div class="form-group">
                                <div class="col-xs-2">
                                    <label>تفويض على</label>
                                </div>
                                <div class="col-xs-10">
                                    {!! Form::select('organization_id', $organizations, NULL, ['id' => 'organization_id', 'class' => 'form-control select2', 'required' => true]) !!}
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-2">
                                    <label>إسم الموظف</label>
                                </div>
                                <div class="col-xs-10">
                                    {!! Form::select('auth_employee_id', $employeesData, NULL, ['id' => 'auth_employee_id', 'class' => 'form-control', 'required' => true]) !!}
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-xs-2">
                                    <label>من تاريخ</label>
                                </div>
                                <div class="col-xs-10">
                                    {!! Form::text('from_date', NULL, ['id' => 'from_date', 'class' => 'form-control en-datepicker-input', 'required' => true]) !!}
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <div class="col-xs-2">
                                    <label>الى تاريخ</label>
                                </div>
                                <div class="col-xs-10">
                                    {!! Form::text('to_date', NULL, ['id' => 'to_date', 'class' => 'form-control en-datepicker-input', 'required' => true]) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-2">
                                    <label>الصلاحيات</label>
                                </div>
                                <div class="col-xs-10">
                                    <div class="mt-checkbox-list">
                                        @foreach ($apps as $app)
                                            <label class="mt-checkbox mt-checkbox-outline"> {{ $app->name }}
                                                {!! Form::checkbox('powers[]', $app->id) !!}
                                                <span></span>
                                            </label> 
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12 col-xs-push-2">
                                    {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i> تفويض', ['type' => 'submit', 'class' => 'btn green-haze']) !!}
                                </div>
                            </div>

                        </div>
                    {!! Form::close() !!}

                </div>

            </div>


        </div>
    </div>

@endsection


@section('scripts_2')

    <script>
        $("#organization_id").change(function() {
            $('#auth_employee_id').empty().trigger("change");
        });
    </script>

@endsection