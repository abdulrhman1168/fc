@extends('layouts.main.index')
@section('page')


    <div class="panel-heading">
        {{ __('transport::app.add_city') }}
    </div>

    <form action="{{route('trans.store')}}" method="post" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{\Auth::user()->user_id}}">


        <div class="panal-body">
            <div class="form-group {{ $errors->has('name_ar') ? ' has-error' : '' }}">
              <div class="col-xs-6">

                <label for="ex3">{{ __('transport::app.name_ar') }}</label>
                <input name="name_ar" class="form-control" id="ex3" type="text" required >
                @if ($errors->has('name_ar'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name_ar') }}</strong>
                    </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('name_en') ? ' has-error' : '' }}">
              <div class="col-xs-6">
              <label for="ex3">{{ __('transport::app.name_en') }}</label>
              <input name="name_en" class="form-control" id="ex3" type="text"  required>
              @if ($errors->has('name_en'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name_en') }}</strong>
                  </span>
              @endif
              </div>
            </div>
        </div>


        <div class="panel-footer">
            <input type="submit" class="btn btn-primary btn-md"
                   value="{{ __('transport::app.save')}}" name="city_s">

        </div>

    </form>

@stop

