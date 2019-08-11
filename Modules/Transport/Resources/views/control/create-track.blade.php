@extends('layouts.main.index')
@section('page')


    <div class="panel-heading">
        {{ __('transport::app.add_track') }}
    </div>


        <form action="{{route('trans.store')}}" method="post" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="user_id" value="{{\Auth::user()->user_id}}">


<div class="panal-body">
  <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
        <label for="sel1">{{ __('transport::app.city') }}</label>
        <select class="form-control" id="sel1" name="city">
            <option value=""></option>
            @foreach($cities as $row)
                <option value="{{$row->id}}">{{ (App::getLocale() == 'ar') ? $row->name_ar :
                $row->name_en }}
                </option>
            @endforeach

        </select>
        @if ($errors->has('city'))
            <span class="help-block">
              <strong>{{ $errors->first('city') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group {{ $errors->has('district') ? ' has-error' : '' }}">
          <label for="sel1">{{ __('transport::app.district') }}</label>
          <select class="form-control" id="sel1" name="district">
              <option value=""></option>
              @foreach($districts as $row)
                  <option value="{{$row->id}}">{{ (App::getLocale() == 'ar') ? $row->name_ar :
                  $row->name_en }}
                  </option>
              @endforeach

          </select>
          @if ($errors->has('district'))
              <span class="help-block">
                <strong>{{ $errors->first('district') }}</strong>
              </span>
          @endif
      </div>

      <div class="form-group {{ $errors->has('college') ? ' has-error' : '' }}">
                <label for="sel1">{{ __('transport::app.college') }}</label>
                <select class="form-control" id="sel1" name="college">
                    <option value=""></option>
                    @foreach($college as $row)
                        <option value="{{$row->id}}">{{$row->name}}</option>
                    @endforeach

                </select>

            @if ($errors->has('college'))
                <span class="help-block">
                  <strong>{{ $errors->first('college') }}</strong>
                </span>
            @endif
        </div>


<div class="panel-footer">
    <input type="submit" name="track_s" class="btn btn-primary btn-md"
           value="{{ __('transport::app.save')}}">

</div>

</form>
</div>


@stop
