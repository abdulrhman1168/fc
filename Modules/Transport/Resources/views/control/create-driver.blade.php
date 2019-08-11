@extends('layouts.main.index')
@section('page')


    <div class="panel-heading">
        {{ __('transport::app.add_diver') }}
    </div>


    <form action="{{route('trans.store')}}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value=>


            <div class="panal-body">
              <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="ex3">{{ __('transport::app.driver_name') }}</label>
                <input name="name" class="form-control" id="ex3" type="text">
                @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('mobile') ? ' has-error' : '' }}">
                <label for="ex3">{{ __('transport::app.mobile') }}</label>
                <input name="mobile" class="form-control" id="ex3" type="text">
                @if ($errors->has('mobile'))
                    <span class="help-block">
                      <strong>{{ $errors->first('mobile') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('bus_no') ? ' has-error' : '' }}">
                <label for="ex3">{{ __('transport::app.bus_no') }}</label>
                <input name="bus_no" class="form-control" id="ex3" type="text">
                @if ($errors->has('bus_no'))
                    <span class="help-block">
                      <strong>{{ $errors->first('bus_no') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('plate_no') ? ' has-error' : '' }}">
            <label for="ex3">{{ __('transport::app.plate_no') }}</label>
                <input name="plate_no" class="form-control" id="ex3" type="text">
                @if ($errors->has('plate_no'))
                    <span class="help-block">
                      <strong>{{ $errors->first('plate_no') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('companion') ? ' has-error' : '' }}">
            <label for="ex3">{{ __('transport::app.companion') }}</label>
                <input name="companion" class="form-control" id="ex3">
                @if ($errors->has('companion'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companion') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('companion_no') ? ' has-error' : '' }}">
                <label for="ex3">{{ __('transport::app.companion_no') }}</label>
                <input name="companion_no" class="form-control" id="ex3" type="text">
                @if ($errors->has('companion_no'))
                    <span class="help-block">
                      <strong>{{ $errors->first('companion_no') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('track') ? ' has-error' : '' }}">
              <label for="form_control_1"> {{ __('transport::app.track') }}</label>

                <select class="form-control edited" id="form_control_1"name="track" >
                    <option value=""></option>
                    @foreach($track as $row)
                        <option value="{{$row->id}}">{{$row->citys->name_ar . "/" .
                $row->districts->name_ar . "/" . $row->colleges->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('track'))
                    <span class="help-block">
                      <strong>{{ $errors->first('track') }}</strong>
                    </span>
                @endif
            </div>
          </div>
            <div class="panel-footer">
                <input type="submit" name="driver" class="btn btn-primary btn-md" value="{{ __('transport::app.save')}}">


            </div>

    </form>


@stop
