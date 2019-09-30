@if($request->current_step >= 2)
<div class="portlet-title">
        <div class="caption">
        <i class="fa fa-list"></i>
       {{ __('myservices::app.deanship_staff_affairs') }}
      </div>
</div>
@endif

@if($request->current_step > 2)
<div class="row">
        <div class="col-md-12">
               <table class="table table-striped panel-body">
                   <tbody>
                       <tr>
                           <th>تاريخ التوقيع بالهجري</th>
                           <td>{{ $request->step_3_approval_date }}</td>
                       </tr>
                       <tr>
                            <th>إسم الموظف المختص</th>
                            <td>{{ $request->step3Approval->arabic_name }}</td>
                        </tr>
                        <tr>
                            <th>التاريخ الهجري لبداية عقده</th>
                            <td>{{ $request->step_4_contract_start_date }}</td>
                        </tr>
                        <tr>
                            <th>هل صرف له بدل سكن في العقود السابقة ؟</th>
                            <td>{{ $request->step_4_is_get_allowance_prev == 1 ? 'نعم' : 'لا' }}</td>
                        </tr>
                   </tbody>
               </table>
        </div>
</div>

@endif

@if($request->current_step == 2)
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.step4-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}

        <div class="row">
                <div class="col-md-12">
                        <div class="form-group {{ $errors->has('step_4_contract_start_date') ? ' has-error' : '' }} col-md-12">
                                <label for="step_4_contract_start_date" class="col-md-4 control-label">
                                    التاريخ الهجري لبداية عقده بالجامعة
                                </label>
                                <div class="col-md-8">
                                    {!! Form::text('step_4_contract_start_date', old('step_4_contract_start_date'), ['class' => 'form-control hijri-datepicker-input'])!!}
                                    @if ($errors->has('step_4_contract_start_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_4_contract_start_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>
                </div>
                <br/>
                <div class="col-md-12">
                        <div class="form-group {{ $errors->has('step_4_is_get_allowance_prev') ? ' has-error' : '' }} col-md-12">
                                <label for="step_4_is_get_allowance_prev" class="col-md-4 control-label">
                                    صرف له بدل سكن في العقود السابقة
                                </label>
                                <div class="col-md-8">
                                        {!! Form::select('step_4_is_get_allowance_prev', [ 1 =>'نعم', 0 => 'لا']  , old('step_4_is_get_allowance_prev'), ['class' => 'form-control'])!!}
                                    @if ($errors->has('step_4_is_get_allowance_prev'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_4_is_get_allowance_prev') }}</strong>
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