@extends('layouts.main.index')

@section('page')

  <div class="row">
      <div class="col-md-12">
          <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                <i class="fa fa-list"></i>
                {{ __('departmentservices::app.discount_request_details') }}

                <input type="button" value="طباعة" onClick="window.print()" class="btn btn-primary hidden-print">
              </div>
            </div>
               <div class="row">
                 <div class="col-md-12">
                        <table class="table table-striped panel-body">
                            <tbody>
                                <tr>
                                    <th>{{ __('departmentservices::app.request_number') }}</th>
                                    <td>{{ $discountRequest->request_number }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('departmentservices::app.request_month') }}</th>
                                    <td><b>{{ $discountRequest->month }}</b></td>
                                </tr>
                                <tr>
                                    <th>{{ __('departmentservices::app.request_date') }}</th>
                                    <td>{{ $discountRequest->created_at }}</td>
                                </tr>
                                <tr>
                                        <th>{{ __('departmentservices::app.request_hijri_date') }}</th>
                                        <td>{{ $discountRequest->hijri_date }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('departmentservices::app.creator_name') }}</th>
                                    <td>{{ $discountRequest->creator->employeeObject->arabic_name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('departmentservices::app.department') }}</th>
                                    <td>{{ $discountRequest->creator->employeeObject->department->name }}</td>
                                </tr>
                                <tr>
                                        <th>{{ __('departmentservices::app.approved_status') }}</th>
                                        <td>
                                            {{ $discountRequest->approvalStatus() }}
                                            <br/><br/>
                                            @if($discountRequest->hasAbilityToApprove())

                                                {!! Form::model($discountRequest->id, ['method' => 'post', 'route' => ['salary-discount-requests.approve', $discountRequest->id], 'class' =>'form-inline yes-no-submit-modal-form hidden-print', 'style' => 'display: inline;']) !!}
                                                        {!! Form::hidden('id', $discountRequest->id) !!}
                                                        <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
                                                        <i class="fa fa-check"></i>
                                                        {{ __('departmentservices::app.approve') }}
                                                        </button>
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                </tr>

                                @if($canClose && !$discountRequest->is_closed)
                                <tr>
                                    <th></th>
                                    <td>
                                    {!! Form::model($discountRequest->id, ['method' => 'post', 'route' => ['salary-discount-requests.close', $discountRequest->id], 'class' =>'form-inline yes-no-submit-modal-form hidden-print', 'style' => 'display: inline;']) !!}
                                            {!! Form::hidden('id', $discountRequest->id) !!}
                                            <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
                                            <i class="fa fa-close"></i>
                                            {{ __('departmentservices::app.close_request') }}
                                            </button>
                                    {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endif

                                @if($discountRequest->is_closed)
                                <tr>
                                    <th>حالة الطلب</th>
                                    <td>مغلق</td>
                                </tr>
                                @endif
                                
                            </tbody>
                        </table>

                        <h3>{{ __('departmentservices::app.employees') }}</h3>
                        <br/>

                        <table class="table table-striped panel-body">
                            <thead>
                                    <tr>
                                        <th>{{ __('departmentservices::app.employee_id') }}</th>
                                        <th>{{ __('departmentservices::app.name') }}</th>
                                        <th>{{ __('departmentservices::app.id_no') }}</th>
                                        <th>{{ __('departmentservices::app.absent_days') }}</th>
                                        <th>{{ __('departmentservices::app.hours_late') }}</th>
                                        <th>{{ __('departmentservices::app.minutes_late') }}</th>
                                        <th>{{ __('departmentservices::app.total') }}</th>
                                    </tr>
                                
                            </thead>
                            <tbody>
                                    @foreach($discountRequest->employees as $employee)
                                    <tr>
                                        <td>{{ $employee->employee_id}}</td>
                                        <td>{{ $employee->monthData()->emp_name}}</td>
                                        <td>{{ $employee->monthData()->natio_id}}</td>
                                        <td>
                                            {{ $employee->monthData()->numof_absentdays}}<br/>
                                            <div class="alert-info">
                                                {{ $employee->monthData()->absenceDaysNumbers()}}
                                            </div>
                                        </td>
                                        <td>{{ $employee->monthData()->late_hours}}</td>
                                        <td>{{ $employee->monthData()->late_mins}}</td>
                                        <td>{{ $employee->monthData()->totalLate()}}</td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                 </div>
               </div>
               <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('salary-discount-requests.index') }}" class="btn btn-success hidden-print">
                            <i class="fa fa-list"></i>
                            {{ __('messages.back')}}
                        </a>
                    </div>
              </div>
          </div>
      </div>
  </div>

@endsection
