@extends('layouts.main.index')


@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list"></i>
          <span class="caption-subject sbold uppercase">طلبات الإجازات لإعضاء هيئة التدريس</span>
        </div>
      </div>
       <table class="table table-striped panel-body">
            <thead>
                <tr>
                    <th>الرقم الوظيفي</th>
                    <th>الموظف</th>
                    <th>القسم</th>
                    <th>نوع الأجازة</th>
                    <th>الرصيد</th>
                    <th>تاريخ البدء</th>
                    <th>تاريخ الإنتهاء</th>
                    <th>المدة</th>
                    <th>الموظف البديل</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($vacations as $vacation)
                <tr>
                    <td>{{ optional($vacation->employee)->employee_id }}</td>
                    <td>{{ optional($vacation->employee)->arabic_name }}</td>
                    <td>{{ optional($vacation->employee)->directDepartment->name }}</td>
                    <td>{{ $vacationTypes[$vacation->vacation_code] }}</td>
                    <td>{{ Modules\MyServices\Entities\Attendance\Vacation::getBalance(optional($vacation->employee)->employee_id, $vacation->year_code, $vacation->vacation_code) }} يوم</td>
                    <td>{{ $vacation->start_date->format('Y-m-d')}}</td>
                    <td>{{ $vacation->end_date->format('Y-m-d')}}</td>
                    <td>{{ $vacation->period}} يوم</td>
                    <td>{{ optional($vacation->alternativeEmployee)->arabic_name}}</td>
                    <td>{{ $statueses[$vacation->status]}}</td>
                    <td>
                        @if($vacation->status == 9)
                            {!! Form::model($vacation->id, ['method' => 'post', 'route' => ['confirm-hr-vacation', $vacation->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden('id', $vacation->id) !!}
                                {!! Form::hidden('status', 3) !!}
                                <button type="submit" class="btn btn-success yes-no-submit-button-form" >
                                <i class="fa fa-check"></i>
                                {{ __('departmentservices::app.approve') }}
                                </button>
                            {!! Form::close() !!}
                            {!! Form::model($vacation->id, ['method' => 'post', 'route' => ['confirm-hr-vacation', $vacation->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden('id', $vacation->id) !!}
                                {!! Form::hidden('status', 7) !!}
                                <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
                                <i class="fa fa-check"></i>
                                {{ __('departmentservices::app.reject') }}
                            </button>
                            {!! Form::close() !!}
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

  </div>
@endsection
