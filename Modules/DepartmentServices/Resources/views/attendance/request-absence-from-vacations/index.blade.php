@extends('layouts.main.index')

@section('page')

    <div class="portlet light bordered">
        
        <div class="portlet-title">

            <div class="caption">
                <i class="fa fa-list"></i>
                <span class="caption-subject sbold uppercase">طلبات احتساب غياب من الإجازة العادية</span>
            </div>
        
            <div class="actions">
                <div class="btn-group btn-group-devided" data-toggle="buttons">

                </div>
            </div>
        </div>
      
        <table class="table table-striped panel-body">

            <thead>
                <tr>
                    <th>#</th>
                    <th>الرقم الوظيفي</th>
                    <th>اسم الموظف</th>
                    <th>الإدارة</th>
                    <th>تاريخ البداية</th>
                    <th>تاريخ النهاية</th>
                    <th>المدة</th>
                    <th></th>
                </tr>
            </thead>

                @foreach($requestAbsenceVacations as $vacation)
                <tr>
                    <td>{{$vacation->id}}</td>
                    <td>{{$vacation->employee->employee_id}}</td>
                    <td>{{$vacation->employee->arabic_name}}</td>
                    <td>{{$vacation->employee->directDepartment->name}}</td>
                    <td>{{$vacation->start_date->format('Y-m-d')}}</td>
                    <td>{{$vacation->end_date->format('Y-m-d')}}</td>
                    <td>{{$vacation->vacation_period}} ايام</td>
                    <td>

                        @if($vacation->canCheckRequest)

                            {!! Form::model($vacation->id, ['method' => 'PUT', 'route' => ['department-services.request-absence-from-vacations.update', $vacation->id], 'class' => 'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden('status', 4) !!}
                            
                                <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
                                    <i class="fa fa-check"></i>
                                    {{ __('departmentservices::app.reject') }}
                                </button>
                            {!! Form::close() !!}

                            {!! Form::model($vacation->id, ['method' => 'PUT', 'route' => ['department-services.request-absence-from-vacations.update', $vacation->id], 'class' => 'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden('status', 2) !!}
                            
                                <button type="submit" class="btn btn-success yes-no-submit-button-form" >
                                    <i class="fa fa-check"></i>
                                    {{ __('departmentservices::app.initial_approve') }}
                                </button>
                            {!! Form::close() !!}

                        @elseif($vacation->canConfirmRequest)
                            
                            {!! Form::model($vacation->id, ['method' => 'PUT', 'route' => ['department-services.request-absence-from-vacations.update', $vacation->id], 'class' => 'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden('status', 5) !!}
                                
                                <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
                                    <i class="fa fa-check"></i>
                                    {{ __('departmentservices::app.reject') }}
                                </button>

                            {!! Form::close() !!}

                            {!! Form::model($vacation->id, ['method' => 'PUT', 'route' => ['department-services.request-absence-from-vacations.update', $vacation->id], 'class' => 'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden('status', 3) !!}
                                
                                <button type="submit" class="btn btn-success yes-no-submit-button-form" >
                                    <i class="fa fa-check"></i>
                                    {{ __('departmentservices::app.approve') }}
                                </button>

                            {!! Form::close() !!}

                        @endif

                    </td>
                </tr>
                @endforeach

            <tbody>
            </tbody>
            
        </table>
    
    </div>

@endsection
