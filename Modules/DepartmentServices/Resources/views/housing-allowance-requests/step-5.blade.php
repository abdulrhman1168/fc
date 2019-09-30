
@if($request->current_step >= 3)
<div class="portlet-title">
        <div class="caption">
        <i class="fa fa-list"></i>
       {{ __('myservices::app.deanship_staff_support_services') }}
      </div>
</div>
@endif

@if($request->current_step > 3)
<div class="row">
        <div class="col-md-12">
               <table class="table table-striped panel-body">
                   <tbody>
                       <tr>
                           <th>
                               تاريخ التوقيع بالهجري
                            </th>
                           <td>{{ $request->step_4_approval_date }}</td>
                       </tr>
                       <tr>
                            <th>إسم الموظف المختص</th>
                            <td>{{ $request->step4Approval->arabic_name }}</td>
                        </tr>
                        <tr>
                            <th>
                                عدد التابعين
                            </th>
                            <td>{{ $request->step_5_companions_no }}</td>
                        </tr>
                        <tr>
                            <th>
                                اسم الزوج / الزوجة
                            </th>
                            <td>{{ $request->step_5_husband_wife_name }}</td>
                        </tr>
                        <tr>
                            <th>
                                رقم إقامة الزوج / الزوجة
                            </th>
                            <td>{{ $request->step_5_husband_national_id }}</td>
                        </tr>
                        <tr>
                            <th>
                                التاريخ الهجري لأخر إستقدام
                            </th>
                            <td>{{ $request->step_5_last_recruitment_date }}</td>
                        </tr>
                        <tr>
                            <th>
                                هل تم صرف أوامر ركاب لعائلته ؟ 
                            </th>
                            <td>{{ $request->step_5_is_get_trav_for_family == 1? 'نعم' : 'لا' }}</td>
                        </tr>

                        <tr>
                            <th>
                                سبق للمذكور استقدام عائلته ؟ 
                            </th>
                            <td>{{ $request->step_5_is_recruitment_before == 1? 'نعم' : 'لا' }}</td>
                        </tr>
                   </tbody>
               </table>
        </div>
</div>

@endif

@if($request->current_step == 3)
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.step5-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}

        <div class="row">
                <div class="row">
                        <div class="form-group {{ $errors->has('step_5_companions_no') ? ' has-error' : '' }} col-md-12">
                                <label for="step_5_companions_no" class="col-md-4 control-label">
                                    عدد التابعين
                                </label>
                                <div class="col-md-8">
                                    {!! Form::text('step_5_companions_no', old('step_5_companions_no'), ['class' => 'form-control'])!!}
                                    @if ($errors->has('step_5_companions_no'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_5_companions_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>
                </div>
                <br/>
                <div class="row">
                        <div class="form-group {{ $errors->has('step_5_husband_wife_name') ? ' has-error' : '' }} col-md-12">
                                <label for="step_5_husband_wife_name" class="col-md-4 control-label">
                                        اسم الزوج / الزوجة
                                </label>
                                <div class="col-md-8">
                                    {!! Form::text('step_5_husband_wife_name', old('step_5_husband_wife_name'), ['class' => 'form-control'])!!}
                                    @if ($errors->has('step_5_husband_wife_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_5_husband_wife_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>
                </div>
                <br/>
                <div class="row">
                        <div class="form-group {{ $errors->has('step_5_husband_national_id') ? ' has-error' : '' }} col-md-12">
                                <label for="step_5_husband_national_id" class="col-md-4 control-label">
                                        رقم إقامة الزوج / الزوجة
                                </label>
                                <div class="col-md-8">
                                    {!! Form::text('step_5_husband_national_id', old('step_5_husband_national_id'), ['class' => 'form-control'])!!}
                                    @if ($errors->has('step_5_husband_national_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_5_husband_national_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>
                </div>
                <br/>
                <div class="row">
                        <div class="form-group {{ $errors->has('step_5_last_recruitment_date') ? ' has-error' : '' }} col-md-12">
                                <label for="step_5_last_recruitment_date" class="col-md-4 control-label">
                                        التاريخ الهجري لأخر إستقدام
                                </label>
                                <div class="col-md-8">
                                    {!! Form::text('step_5_last_recruitment_date', old('step_5_last_recruitment_date'), ['class' => 'form-control hijri-datepicker-input'])!!}
                                    @if ($errors->has('step_5_last_recruitment_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_5_last_recruitment_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>
                </div>
                <br/>
                <div class="row">
                        <div class="form-group {{ $errors->has('step_5_is_get_trav_for_family') ? ' has-error' : '' }} col-md-12">
                                <label for="step_5_is_get_trav_for_family" class="col-md-4 control-label">
                                        هل تم صرف أوامر ركاب لعائلته ؟ 
                                </label>
                                <div class="col-md-8">
                                        {!! Form::select('step_5_is_get_trav_for_family', [ 1 =>'نعم', 0 => 'لا']  , old('step_5_is_get_trav_for_family'), ['class' => 'form-control'])!!}
                                    @if ($errors->has('step_5_is_get_trav_for_family'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_5_is_get_trav_for_family') }}</strong>
                                        </span>
                                    @endif
                                </div>
                        </div>
                </div>
                <br/>
                <div class="row">
                        <div class="form-group {{ $errors->has('step_5_is_recruitment_before') ? ' has-error' : '' }} col-md-12">
                                <label for="step_5_is_recruitment_before" class="col-md-4 control-label">
                                        سبق للمذكور استقدام عائلته ؟ 
                                </label>
                                <div class="col-md-8">
                                        {!! Form::select('step_5_is_recruitment_before', [ 1 =>'نعم', 0 => 'لا']  , old('step_5_is_recruitment_before'), ['class' => 'form-control'])!!}
                                    @if ($errors->has('step_5_is_recruitment_before'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('step_5_is_recruitment_before') }}</strong>
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