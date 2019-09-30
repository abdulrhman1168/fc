@if ($currentEmployeeId == $request->step_1_approval_user_id && $request->status == 1)
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.check-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}
        {!! Form::hidden('status', 2) !!}
        <button type="submit" class="btn btn-success yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.initial_approve') }}
        </button>
    {!! Form::close() !!}
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.check-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}
        {!! Form::hidden('status', 4) !!}
        <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.reject') }}
        </button>
    {!! Form::close() !!}
@endif
@if ($currentEmployeeId == $request->step_2_approval_user_id && $request->status == 2)
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.confirm-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}
        {!! Form::hidden('status', 3) !!}
        <button type="submit" class="btn btn-success yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.approve') }}
        </button>
    {!! Form::close() !!}
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.confirm-housing-allowance-request', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}
        {!! Form::hidden('status', 5) !!}
        <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.reject') }}
    </button>
   {!! Form::close() !!}
@endif