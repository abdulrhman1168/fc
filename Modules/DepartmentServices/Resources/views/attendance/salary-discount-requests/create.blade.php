@extends('layouts.main.index')

@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list"></i>
          <span class="caption-subject sbold uppercase">{{ __('departmentservices::app.salary_discount_request') }}</span>
        </div>
        <div class="actions">
        </div>
      </div>

      <div class="row">
        {!! Form::open(['route' =>  ['salary-discount-requests.create'], 'method'=>'get']) !!}
        <div class="row">
          <div class="col-md-2">
             {!! Form::select('month', [ null => __('departmentservices::app.select_month') ] + $months, old('month'), ['class' => 'form-control'])!!}
          </div>
          <div class="col-md-2">
                {!! Form::select('year', [ null => __('departmentservices::app.select_year') ] + $years, old('year'), ['class' => 'form-control'])!!}
          </div>

          <div class="col-md-2">
            {!! Form::select('sex', [ null => __('departmentservices::app.select_sex'), '1' =>  __('departmentservices::app.male'), '2' =>  __('departmentservices::app.female'), ] , old('year'), ['class' => 'form-control'])!!}
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-circle btn-icon-only blue">
                <i class="fa fa-search"></i>
            </button>
          </div>

        </div>
        <br/>
        {!! Form::close() !!}
    </div>
    <br/>
    {!! Form::model($discountRequest,['route' =>  ['salary-discount-requests.store'],'method'=>'post' ]) !!}
       {{ Form::hidden('month', old('month')) }}
       {{ Form::hidden('year', old('year')) }}

       @if($employees->count() > 0)
            <button type="submit" class="btn btn-success yes-no-submit-button-form">
                    <i class="fa fa-plus"></i>
                    {{ __('departmentservices::app.create_discount_request') }}
            </button>
       @endif

       <table class="table table-striped panel-body">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="checkAll">
                    </th>
                    <th>{{ __('departmentservices::app.employee_id') }}</th>
                    <th>{{ __('departmentservices::app.name') }}</th>
                    <th>{{ __('departmentservices::app.month') }}</th>
                    <th width="30%">{{ __('departmentservices::app.absent_days') }}</th>
                    <th>{{ __('departmentservices::app.hours_late') }}</th>
                    <th>{{ __('departmentservices::app.minutes_late') }}</th>
                    <th>{{ __('departmentservices::app.total') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    @if($employee->display())
                        <tr>
                            <td>
                                {{ Form::checkbox('selected_employees_ids[]', $employee->emp_jobid) }}
                            </td>
                            <td>{{ $employee->emp_jobid}}</td>
                            <td>{{ $employee->emp_name}}</td>
                            <td>{{ $employee->hijri_month}}</td>
                            <td>
                                {{ $employee->numof_absentdays}}<br/>
                                {{ $employee->all_absent_dates}}
                            </td>
                            <td>{{ $employee->late_hours}}</td>
                            <td>{{ $employee->late_mins}}</td>
                            <td>
                                {{ str_replace(["days", "Minutes", "Hours"], [__('departmentservices::app.days'), __('departmentservices::app.minutes'), __('departmentservices::app.hours')],$employee->overall_late)}}
                            </td>
                            <td>
                                <a href="{{route('salary-discount-requests.create', 
                                                  [
                                                      'statement' => true,
                                                      'month' => $month,
                                                      'year' => $year,
                                                      'sex' => $sex,
                                                      'employee_id' => $employee->emp_jobid
                                                  ]
                                                )
                                         }}" class="text-primary" target="_blank">
                                    <i class="fa fa-file"></i>
                                    طباعة إفادة
                                </a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    {!! Form::close() !!}
  </div>
@endsection
