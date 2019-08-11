@if($request->hr_start_work_approval == 1)
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.check-hr-start-work-requests', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}
        {!! Form::hidden('status', 2) !!}
        <button type="submit" class="btn btn-success yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.approve') }}
        </button>
    {!! Form::close() !!}
    {!! Form::model($request->id, ['method' => 'post', 'route' => ['department-services.check-hr-start-work-requests', $request->id], 'class' =>'form-inline yes-no-submit-modal-form', 'style' => 'display: inline;']) !!}
        {!! Form::hidden('id', $request->id) !!}
        {!! Form::hidden('status', 3) !!}
        <button type="submit" class="btn btn-danger yes-no-submit-button-form" >
        <i class="fa fa-check"></i>
        {{ __('departmentservices::app.reject') }}
        </button>
    {!! Form::close() !!}
@endif
