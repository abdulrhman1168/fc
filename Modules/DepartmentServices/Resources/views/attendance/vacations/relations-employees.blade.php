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
                    <th>رقم القرار</th>
                    <th>الموظف</th>
                    <th>رقم الإقامة</th>
                    <th>القسم</th>
                    <th>نوع الأجازة</th>
                    <th>تاريخ البدء</th>
                    <th>تاريخ الإنتهاء</th>
                    <th>المدة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($vacations as $vacation)
                <tr>
                    <td>{{ optional($vacation->employee)->employee_id }}</td>
                    <td>{{ $vacation->vacation_no }}</td>
                    <td>{{ optional($vacation->employee)->arabic_name }}</td>
                    <td>{{ optional($vacation->employee)->national_id }}</td>
                    <td>{{ optional($vacation->employee)->directDepartment->name }}</td>
                    <td>{{ $vacationTypes[$vacation->vacation_code] }}</td>
                    <td>{{ $vacation->start_date->format('Y-m-d')}}</td>
                    <td>{{ $vacation->end_date->format('Y-m-d')}}</td>
                    <td>{{ $vacation->period}} يوم</td>
                    <td>
                        @if($vacation->status == 3 && $vacation->visa_status == 0)
                            {!! Form::model($vacation->id, ['method' => 'post', 'route' => ['confirm-relations-employees-vacation', $vacation->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                                {!! Form::hidden('id', $vacation->id) !!}
                                {!! Form::hidden('visa_status', 1) !!}
                                <button type="submit" class="btn btn-success yes-no-submit-button-form" >
                                <i class="fa fa-check"></i>
                                {{ __('departmentservices::app.Visa-done') }}
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
