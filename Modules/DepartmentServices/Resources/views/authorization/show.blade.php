@extends('layouts.main.index')

@section('page')

    <div class="row">
        <div class="col-md-12">

            @if(session()->has('error'))
                <div class="alert alert-danger">{{ session()->get('error') }}</div>
            @elseif(session()->has('success'))
                <div class="alert alert-success">{{ session()->get('success') }}</div>
            @endif

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-info" aria-hidden="true"></i> عرض تفاصيل التفويض
                    </div>

                    <div class="actions">
                        <a href="{{ route('authorization.index') }}" class="btn btn-default"><i aria-hidden="true" class="fa fa-chevron-right"></i> رجوع</a>
                    </div>
                </div>
                <div class="portlet-body form">
                    
                    <div class="form-horizontal form-bordered">

                        <div class="form-group">
                            <div class="col-xs-2">
                                <label>مفوض على</label>
                            </div>
                            <div class="col-xs-10">
                                {!! Form::text('organization_id', $authorizationEmployee->organization->name, ['id' => 'organization_id', 'class' => 'form-control', 'disabled' => true]) !!}
                            </div>
                        </div>
            
                        <div class="form-group">
                            <div class="col-xs-2">
                                <label>إسم الموظف</label>
                            </div>
                            <div class="col-xs-10">
                                {!! Form::text('auth_employee_id', $authorizationEmployee->authorizedEmployee->arabic_name, ['id' => 'auth_employee_id', 'class' => 'form-control', 'disabled' => true]) !!}
                            </div>
                        </div>
                                
                        <div class="form-group">
                            <div class="col-xs-2">
                                <label>من تاريخ</label>
                            </div>
                            <div class="col-xs-10">
                                {!! Form::text('from_date', $authorizationEmployee->from_date->format('Y-m-d'), ['id' => 'from_date', 'class' => 'form-control', 'disabled' => true]) !!}
                            </div>
                        </div>
            
                                
                        <div class="form-group">
                            <div class="col-xs-2">
                                <label>الى تاريخ</label>
                            </div>
                            <div class="col-xs-10">
                                {!! Form::text('to_date', $authorizationEmployee->to_date->format('Y-m-d'), ['id' => 'to_date', 'class' => 'form-control', 'disabled' => true]) !!}
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
                                            {!! Form::checkbox('powers[]', $app->id, true, ['disabled' => true]) !!}
                                            <span></span>
                                        </label> 
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-2">
                                <label>حالة التفويض</label>
                            </div>
                            <div class="col-xs-10">
                                {!! $authorizationEmployee->authorization_status !!}
                            </div>
                        </div>

                    </div>
                    

                </div>
            </div>



        </div>
    </div>

@endsection
