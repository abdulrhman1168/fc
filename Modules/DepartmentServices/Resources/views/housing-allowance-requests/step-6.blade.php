@if($request->current_step >= 4)
<div class="portlet-title">
        <div class="caption">
        <i class="fa fa-list"></i>
       {{ __('myservices::app.utilites_and_housing') }}
      </div>
</div>
@endif

@if($request->current_step > 4)
<div class="row">
        <div class="col-md-12">
               <table class="table table-striped panel-body">
                   <tbody>
                       <tr>
                           <th>تاريخ التوقيع بالهجري</th>
                           <td>{{ $request->step_5_approval_date }}</td>
                       </tr>
                       <tr>
                            <th>إسم الموظف المختص</th>
                            <td>{{ $request->step5Approval->arabic_name }}</td>
                        </tr>
                        <tr>
                            <th>إستحقاقه لبدل السكن </th>
                            <td>{{ $request->housing_allowance_status_name }}</td>
                        </tr>
                   </tbody>
               </table>
        </div>
        {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.step-housing-allowance-request-back', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}

        <div class="row">
                <div class="col-md-12">
                        <div class="form-group {{ $errors->has('step_6_housing_allow_status') ? ' has-error' : '' }} col-md-12">
                                <label for="step_6_housing_allow_status" class="col-md-4 control-label">
                                   {{__('departmentservices::app.back_request_to')}} 
                                </label>
                                <div class="col-md-8">
                                        {!! Form::select('step_back', [ 7 => __('myservices::app.deanship_staff_salary'), 6 => __('myservices::app.utilites_and_housing')], ['class' => 'form-control'])!!}
                                    @if ($errors->has('step_6_housing_allow_status'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_6_housing_allow_status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>
                </div>
        </div>
        <br/>
        <button type="submit" class="btn btn-success yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.reply') }}
        </button>
    {!! Form::close() !!}
</div>

@endif

@if($request->current_step == 4)
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.step6-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}

        <div class="row">
                <div class="col-md-12">
                        <div class="form-group {{ $errors->has('step_6_housing_allow_status') ? ' has-error' : '' }} col-md-12">
                                <label for="step_6_housing_allow_status" class="col-md-4 control-label">
                                   إستحقاقه لبدل السكن
                                </label>
                                <div class="col-md-8">
                                        {!! Form::select('step_6_housing_allow_status', [  1 => __('myservices::app.deserve_housing_allowance'), 2 => __('myservices::app.deserve_housing')]  , old('step_6_housing_allow_status'), ['class' => 'form-control'])!!}
                                    @if ($errors->has('step_6_housing_allow_status'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_6_housing_allow_status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>
                </div>
        </div>
        <br/>
        <button type="submit" class="btn btn-success yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.approve') }}
        </button>
    {!! Form::close() !!}
    <br/><br/>
@endif