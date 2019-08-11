@extends('layouts.main.index')


@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list"></i>
          <span class="caption-subject sbold uppercase">طلبات بدل السكن</span>
        </div>
      </div>
      <br/>
      <div class="row">
            {!! Form::open(['route' =>  ['department-services.housing-allowance-requests.index'], 'method'=>'get']) !!}
            <div class="row">
              <div class="col-md-2">
                {!! Form::text('id', old('id'), ['class' => 'form-control', 'placeholder' => 'رقم الطلب']) !!}
              </div>
              <div class="col-md-2">
                    {!! Form::text('applicant_user_id', old('applicant_user_id'), ['class' => 'form-control', 'placeholder' => 'الرقم الوظيفي ']) !!}
              </div>

             @if($isSalaryApprove)
                <div class="col-md-3">
                    {{ Form::radio('is_archived', '1', (old('is_archived') == 1 ? true : false) ) }}
                    مأرشف
                    {{ Form::radio('is_archived', '3', (old('is_archived') == 3 ? true : false) ) }}
                    غير مأرشف
                    {{ Form::radio('is_archived', '2', (old('is_archived') == 2 ? true : false) ) }}
                    المأرشف والغير مأرشف
                </div>
             @endif

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
                    <th>رقم الطلب</th>
                    <th>الموظف</th>
                    <th>القسم</th>
                    <th>الإدارة</th>
                    <th>العام الدراسي</th>
                    <th>
                        الخطوة التي يقف عندها حاليًا
                    </th>
                    <th>الحالة</th>
                    <th>الإستحقاقية</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                <tr>
                    <td>{{  $loop->iteration }}</td>
                    <td>{{  $request->id }}</td>
                    <td>{{ $request->applicant->arabic_name }}</td>
                    @if(optional($request->applicant)->directDepartment)
                    <td>{{ optional($request->applicant)->directDepartment->name }}</td>
                    @else
                      <td>لا يوجد لهذا الموظف قسم لذا لابد تحديث بياناته</td>
                    @endif
                    <td>{{ optional($request->applicant)->department->name }}</td>
                    <td>{{ $request->schoolYear->name }}</td>
                    <td>{{ $request->stop_step_name }}</td>
                    <td>{{ $request->status_name }}</td>
                    <td>
                        @if($request->displayhousingAllowanceStatusInIndex())
                        {{ $request->housing_allowance_status_name }}
                        @elseif($request->current_step == 0 && $request->step_2_approval_user_id > 0 && $request->step_2_approval_date)
                          {{__('departmentservices::app.user_already_have_house_before')}}
                        @endif
                        
                    </td>
                    <td>
                        <a href="{{route('department-services.housing-allowance-requests.show', $request)}}" class="btn btn-info">
                            <i class="fa fa-eye"></i>
                            تفاصيل
                        </a>
                        @include('departmentservices::housing-allowance-requests.step-1-2-actions')
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        {!! $requests->render() !!}
        
  </div>
@endsection