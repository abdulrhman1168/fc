@extends('layouts.main.index')

@section('page')
  <div class="panel panel-info">
      <div class="panel-heading">
        اضافة فترة تسجيل
     
      </div>
      <div class="panel-body">
           {!! Form::model($schoolYears,['route' =>  ['trans.save-registration-period'],'method'=>'post' ]) !!} 

            
          
          @if($errors->has('general_error'))
 <div class="alert alert-danger">
        <strong>{{ $errors->first('general_error') }}</strong>
 </div>
@endif


<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
                <label for="start_date" class="col-md-4 control-label">{{  'تاريخ البداية' }}</label>
                <div class="col-md-8">
                    {!! Form::text('start_date', old('start_date'), 
                                 [
                                     'class' => 'form-control hijri-datepicker-input',
                                 ]
                            )
                        !!}
                    @if ($errors->has('start_date'))
                        <span class="help-block">
                            <strong>{{ $errors->first('start_date') }}</strong>
                        </span>
                    @endif
                </div>
        </div>
    </div>
    <div class="col-md-6">
            <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
                    <label for="end_date" class="col-md-4 control-label">{{ 'تاريخ النهاية' }}</label>
                    <div class="col-md-8">
                        {!! Form::text('end_date', old('end_date'), 
                                 [
                                     'class' => 'form-control hijri-datepicker-input',
                                     
                                 ]
                            )
                        !!}
                    </div>
            </div>
    </div>
</div>
<br />

<div class="row">

        <div class="col-md-6">
                <div class="form-group {{ $errors->has('year') ? ' has-error' : '' }}">
                        <label for="year" class="col-md-4 control-label">العام الدراسي</label>
                        <div class="col-md-8">
                                {!! Form::select('year', [null => ''] + $schoolYears , old('year'), 
                                [
                                    'class' => 'form-control',
                                    
                                ]
                        )
                    !!}
                        </div>
                </div>
        </div>

    </div>




          <input type="submit" class="btn btn-lg blue" value="{{ __('messages.save') }}" />
          {!! Form::close() !!}

      </div>
  </div>
@endsection


