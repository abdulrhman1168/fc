@extends('layouts.main.index')

@section('page')

  <div class="row">
      <div class="col-md-12">
          <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-list"></i>
                    {{ __('myservices::app.housing_allowance_request_details') }}
               </div>
               <div class="pull-right">
                    <a href="{{route('department-services.housing-allowance-requests.show', ['id' => $request->id, 'print' => 'yes'])}}" target="_blank" class="btn btn-primary hidden-print">
                        طباعة
                    </a>
                    @if($request->is_archived != 1 && $request->current_step == 6 && $request->isSalaryApproveAbility(Auth::user()))
                        {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.archive-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
                            <button type="submit" class="btn btn-success yes-no-submit-button-form" >
                            <i class="fa fa-check"></i>
                            أرشفة
                            </button>
                        {!! Form::close() !!}
                    @endif

                    @if($request->is_archived == 1)
                        <button class="btn btn-danger" >
                              هذا الطلب مأرشف
                        </button>
                    @endif
               </div>
            </div>
            <div class="portlet-title">
                    <div class="caption">
                    <i class="fa fa-list"></i>
                    بيانات المتقدم
                  </div>
            </div>
               <div class="row">
                 <div class="col-md-12">
                        <table class="table table-striped panel-body">
                            <tbody>
                                <tr>
                                    <th>تاريخ الطلب هجري</th>
                                    <td>{{ $request->created_hijri_date }}</td>
                                </tr>
                                <tr>
                                    <th>إسم المتقدم</th>
                                    <td>{{ $request->applicant->arabic_name }}</td>
                                </tr>
                                <tr>
                                    <th>الرقم الوظيفي</th>
                                    <td>{{ $request->applicant->employee_id }}</td>
                                </tr>
                                <tr>
                                    <th>رقم الإقامة</th>
                                    <td>{{ $request->applicant->national_id }}</td>
                                </tr>
                                <tr>
                                    <th>الوظيفة</th>
                                    <td>{{ $request->applicant->job_info }}</td>
                                </tr>
                                <tr>
                                    <th>جهة العمل</th>
                                    <td>{{ $request->applicant->actual_dept_code_desc }}</td>
                                </tr>
                                <tr>
                                   <th>الجنس</th>
                                    <td>{{ $request->applicant->gender_desc }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('myservices::app.school_year_id') }}</th>
                                    <td>{{ $request->schoolYear->name }}</td>
                                </tr>
                                <tr>
                                        <th>{{ __('myservices::app.husband_or_wife_work_status') }}</th>
                                        <td>{{ $request->husband_wife_work_status_name }}</td>
                                </tr>
                                <tr>
                                        <th>{{ __('myservices::app.husband_or_wife_name') }}</th>
                                        <td>{{ $request->husband_or_wife_name }}</td>
                                </tr>
                                <tr>
                                        <th>{{ __('myservices::app.husband_or_wife_national_id') }}</th>
                                        <td>{{ $request->husband_or_wife_national_id }}</td>
                                </tr>
                                <tr>
                                        <th>{{ __('myservices::app.husband_or_wife_place_of_work') }}</th>
                                        <td>{{ $request->husband_or_wife_place_of_work }}</td>
                                </tr>
                                <tr>
                                        <th>{{ __('myservices::app.companions_no') }}</th>
                                        <td>{{ $request->companions_no }}</td>
                                </tr>
                                <tr>
                                        <th>{{ __('myservices::app.status') }}</th>
                                        <td>{{ $request->status_name }}</td>
                                </tr>
                                 <tr>
                                     <th>نعم </th>
                                     <td>اقر بصحة بياناتي وفي حال تبين خلاف ذلك فاءنني أكون مسئول عن أي التزامات مالية أو عينية تقرها إدارة الجامعة</td>
                                 </tr>
                                 <tr>
                                        <th></th>
                                        <td>
                                            @include('departmentservices::housing-allowance-requests.step-1-2-actions')
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                 </div>
               </div>

              
               @include('departmentservices::housing-allowance-requests.step-4')

               @include('departmentservices::housing-allowance-requests.step-5')

               @include('departmentservices::housing-allowance-requests.step-6')

               @include('departmentservices::housing-allowance-requests.step-7')
               
               <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('department-services.housing-allowance-requests.index') }}" class="btn btn-success hidden-print">
                            <i class="fa fa-list"></i>
                            {{ __('messages.back')}}
                        </a>
                    </div>
              </div>
          </div>
      </div>
  </div>

@endsection
