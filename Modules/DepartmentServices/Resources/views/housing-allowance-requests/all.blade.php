@extends('layouts.main.index')


@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list"></i>
          <span class="caption-subject sbold uppercase">طلبات بدل السكن</span>
        </div>
      </div>
      <div class="row">
        {!! Form::open(['route' =>  ['department-services.housing-allowance-all-requests'], 'method'=>'get']) !!}
        <div class="row">
          <div class="col-md-1">
            {!! Form::text('id', old('id'), ['class' => 'form-control', 'placeholder' => 'رقم الطلب']) !!}
          </div>
          <div class="col-md-2">
            {!! Form::text('user_name', old('id'), ['class' => 'form-control', 'placeholder' => 'إسم الموظف']) !!}
          </div>
          <div class="col-md-2">
                {!! Form::text('applicant_user_id', old('applicant_user_id'), ['class' => 'form-control', 'placeholder' => 'الرقم الوظيفي ']) !!}
          </div>
          <div class="col-md-3">
            {!! Form::select('current_step',   [ null => 'الخطوة التي يقف عندها حاليًا'] + $steps , old('current_step'), ['class' => 'form-control'])!!}
          </div>

          <div class="col-md-2">
            {!! Form::select('school_year_id',   [ null => 'العام الدراسي'] + $schoolYears , old('school_year_id'), ['class' => 'form-control'])!!}
          </div>

          <div class="col-md-2">
            <button type="submit" class="btn btn-circle btn-icon-only blue">
                <i class="fa fa-search"></i>
            </button>
          </div>

        </div>
        {!! Form::close() !!}
    </div>
      <br/>
       <table class="table table-striped panel-body">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الموظف</th>
                    <th>القسم</th>
                    <th>الإدارة</th>
                    <th>العام الدراسي</th>
                    <th>
                        الخطوة التي يقف عندها حاليًا
                    </th>
                    <th>الإستحقاق</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->applicant->arabic_name }}</td>
                    <td>{{ optional($request->applicant)->directDepartment->name }}</td>
                    <td>{{ optional($request->applicant)->department->name }} - {{ optional($request->applicant)->department->parent->name }}</td>
                    <td>{{ $request->schoolYear->name }}</td>
                    <td>{{ $request->stop_step_name }}</td>
                    <td>{{ $request->housing_allowance_status_name }}</td>
                    <td>{{ $request->status_name }}</td>
                    <td>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        {!! $requests->render() !!}
  </div>
@endsection