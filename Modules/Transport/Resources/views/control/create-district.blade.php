@extends('layouts.main.index')
@section('page')


    <div class="panel-heading">
        {{ __('transport::app.add_district') }}
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

    <label for="ex3">{{ __('transport::app.name_ar') }}</label>
    <div class="form-group {{ $errors->has('name_ar') ? ' has-error' : '' }}">
    <input name="name_ar" class="form-control" id="ex3" type="text">
    @if ($errors->has('name_ar'))
        <span class="help-block">
          <strong>{{ $errors->first('name_ar') }}</strong>
        </span>
    @endif
</div>



    <label for="ex3">{{ __('transport::app.name_en') }}</label>
    <div class="form-group {{ $errors->has('name_en') ? ' has-error' : '' }}">
    <input name="name_en" class="form-control" id="ex3" type="text">
    @if ($errors->has('name_en'))
        <span class="help-block">
          <strong>{{ $errors->first('name_en') }}</strong>
        </span>
    @endif
</div>




<div class="panel-footer">
    <input type="submit" name="district_s" class="btn btn-primary btn-md"
           value="{{ __('transport::app.save')}}">

</div>

</form>
</div>


@stop
