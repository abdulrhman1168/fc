@extends('layouts.main.index')


@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list"></i>
          <span class="caption-subject sbold uppercase">{{__('departmentservices::app.hr_start_work_requests')}}</span>
        </div>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($new_requests as $request)
                <tr>
                    <td>{{  $loop->iteration }}</td>
                    <td>{{  $request->id }}</td>
                    <td>{{ $request->applicant->arabic_name }}</td>
                    <td>{{ optional($request->applicant)->directDepartment->name }}</td>
                    <td>{{ optional($request->applicant)->department->name }}</td>
                    <td>{{ $request->schoolYear->name }}</td>

                    <td>

                        @include('departmentservices::hr-start-work-requests.step-1-2-actions')
                    </td>
                </tr>
                @endforeach
                @if(!$new_requests->total())
                <tr>
                    <td colspan="7" class="text-center"> {{__('departmentservices::app.no_requests_here')}} </td>
                </tr>
                @endif
            </tbody>
        </table>
        {!! $new_requests->render() !!}
        
  </div>
  <br>
  <br><br><br>
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-list"></i>
          <span class="caption-subject sbold uppercase">{{__('departmentservices::app.hr_start_work_requests_approved')}}</span>
        </div>
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
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approved_requests as $request)
                <tr>
                    <td>{{  $loop->iteration }}</td>
                    <td>{{  $request->id }}</td>
                    <td>{{ $request->applicant->arabic_name }}</td>
                    <td>{{ optional($request->applicant)->directDepartment->name }}</td>
                    <td>{{ optional($request->applicant)->department->name }}</td>
                    <td>{{ $request->schoolYear->name }}</td>
                    @if($request->hr_start_work_approval == 2)
                    <td>{{ __('departmentservices::app.approved_done') }}</td>
                    @elseif($request->hr_start_work_approval == 3)
                    <td>{{ __('departmentservices::app.reject_done') }}</td>
                    @endif

                </tr>
                @endforeach
                @if(!$approved_requests->total())
                <tr>
                    <td colspan="7" class="text-center"> {{__('departmentservices::app.no_requests_here')}} </td>
                </tr>
                @endif
            </tbody>
        </table>
        {!! $approved_requests->render() !!}
        
  </div>
@endsection