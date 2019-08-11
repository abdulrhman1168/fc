<div class="row">
  <div class="form-group {{ $errors->has('report_date') ? ' has-error' : '' }}">
      <label for="name" class="col-md-2 control-label">{{ __('transport::app.report_date') }}</label>

      <div class="col-md-8">

          {!! Form::text('report_date',old('report_date'), ['class' => 'form-control hijri-datepicker-input']) !!}
          @if ($errors->has('report_date'))
              <span class="help-block">
                  <strong>{{ $errors->first('report_date') }}</strong>
              </span>
          @endif
      </div>
  </div>
</div>

<br/>


<div class="row">
  <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
      <label for="name" class="col-md-2 control-label">{{ __('transport::app.report_body') }}</label>

      <div class="col-md-8">

          {!! Form::textarea('body',old('body'), ['class' => 'form-control']) !!}
          @if ($errors->has('body'))
              <span class="help-block">
                  <strong>{{ $errors->first('body') }}</strong>
              </span>
          @endif
      </div>
  </div>
</div>

<br/>

<div class="row">
  <div class="form-group {{ $errors->has('report_resource') ? ' has-error' : '' }}">
      <label for="name" class="col-md-2 control-label">{{ __('transport::app.report_resource') }}</label>

      <div class="col-md-8">

          {!! Form::text('report_resource',old('report_resource'), ['class' => 'form-control']) !!}
          @if ($errors->has('report_resource'))
              <span class="help-block">
                  <strong>{{ $errors->first('report_resource') }}</strong>
              </span>
          @endif
      </div>
  </div>
</div>

<br/>

<div class="row">
  <div class="form-group {{ $errors->has('degree') ? ' has-error' : '' }}">
      <label for="name" class="col-md-2 control-label">{{ __('transport::app.report_degree') }}</label>

      <div class="col-md-8">
          {!! Form::select('degree', $degrees, old('degree'), ['class' => 'form-control'])!!}
          @if ($errors->has('degree'))
              <span class="help-block">
                  <strong>{{ $errors->first('degree') }}</strong>
              </span>
          @endif
      </div>
  </div>
</div>


<br/>

<div class="row">
  <div class="form-group {{ $errors->has('action_from_transport_office') ? ' has-error' : '' }}">
      <label for="name" class="col-md-2 control-label">{{ __('transport::app.action_from_transport_office') }}</label>

      <div class="col-md-8">

          {!! Form::textarea('action_from_transport_office',old('action_from_transport_office'), ['class' => 'form-control']) !!}
          @if ($errors->has('action_from_transport_office'))
              <span class="help-block">
                  <strong>{{ $errors->first('action_from_transport_office') }}</strong>
              </span>
          @endif
      </div>
  </div>
</div>
