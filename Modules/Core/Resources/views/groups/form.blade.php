<div class="row">
  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
      <label for="name" class="col-md-4 control-label">{{ __('messages.name') }}</label>

      <div class="col-md-8">

          {!! Form::text('name',old('name'), ['class' => 'form-control']) !!}
          @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </div>
  </div>
</div>

<br/>

<div class="row">
  <div class="form-group {{ $errors->has('name_en') ? ' has-error' : '' }}">
      <label for="name_en" class="col-md-4 control-label">{{ __('messages.name_en') }}</label>

      <div class="col-md-8">

          {!! Form::text('name_en',old('name_en'), ['class' => 'form-control']) !!}
          @if ($errors->has('name_en'))
              <span class="help-block">
                  <strong>{{ $errors->first('name_en') }}</strong>
              </span>
          @endif
      </div>
  </div>

</div>

<br/>

<div class="row">
  <div class="form-group {{ $errors->has('key') ? ' has-error' : '' }}">
      <label for="key" class="col-md-4 control-label">{{ __('messages.key') }}</label>

      <div class="col-md-8">

          {!! Form::text('key',old('key'), ['class' => 'form-control']) !!}
          @if ($errors->has('key'))
              <span class="help-block">
                  <strong>{{ $errors->first('key') }}</strong>
              </span>
          @endif
      </div>
  </div>

</div>

<br>

<div class="row">
    <div class="form-group {{ $errors->has('parent_id') ? ' has-error' : '' }}">
        <label for="parent_id" class="col-md-4 control-label">{{ __('messages.parent_id') }}</label>
  
        <div class="col-md-8">
  
            {!! Form::select('parent_id', $groups, NULL, ['class' => 'form-control']) !!}
            @if ($errors->has('parent_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('parent_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
  </div>