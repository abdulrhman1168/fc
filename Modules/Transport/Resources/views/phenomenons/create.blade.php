@extends('layouts.main.index')
@section('page')


<div class="panel-heading">
    {{ __('transport::app.Report_on_an_aerial_phenomenon') }}
</div>

    <form action="{{route('phenomenons_store')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user_id" value="{{\Auth::user()->user_id}}">


        <div class="panal-body">

          <div class="form-group {{ $errors->has('phenomenon_status') ? ' has-error' : '' }}">
            <div class="col-xs-6">
            <label for="ex3">{{ __('transport::app.phenomenon_status') }}</label>
            <select class="form-control" name="phenomenon_status" >
            <option value=""></option>
            <option value="0">{{ __('transport::app.incident') }}</option>
            <option value="1">{{ __('transport::app.Expected') }}</option>
            </select>
               @if ($errors->has('phenomenon_status'))
                   <span class="help-block">
                     <strong>{{ $errors->first('phenomenon_status') }}</strong>
                   </span>
               @endif
             </div>
           </div>

          <div class="col-xs-6">
            <div class="form-group {{ $errors->has('phenomenon_type') ? ' has-error' : '' }}">
            <label for="ex3">{{ __('transport::app.phenomenon_type') }}</label>
            <select class="form-control" name="phenomenon_type" >
            <option value=""></option>
            <option value="0">{{ __('transport::app.highـrain') }}</option>
            <option value="1">{{ __('transport::app.torrents_sweeping') }}</option>
            <option value="2">{{ __('transport::app.strong_wind') }}</option>
            <option value="3">{{ __('transport::app.Sandstorm') }}</option>
            <option value="4">{{ __('transport::app.thunderstorm') }}</option>

            </select>
                  @if ($errors->has('phenomenon_type'))
                      <span class="help-block">
                        <strong>{{ $errors->first('phenomenon_type') }}</strong>
                      </span>
                  @endif
                  </div>
                </div>


          <div class="col-xs-6">
            <div class="form-group {{ $errors->has('place') ? ' has-error' : '' }}">
            <label for="ex3">{{ __('transport::app.Place_of_the_author') }}</label>
            <input name="place" class="form-control" id="ex3" type="text"  >
        @if ($errors->has('place'))
            <span class="help-block">
              <strong>{{ $errors->first('place') }}</strong>
            </span>
        @endif
      </div>
    </div>

          <div class="col-xs-6">
            <div class="form-group {{ $errors->has('actualtime') ? ' has-error' : '' }}">
            <label for="ex3">{{ __('transport::app.actualtime') }}</label>
            <input name="actualtime"  class="form-control" id="ex3" type="time" >
        @if ($errors->has('actualtime'))
            <span class="help-block">
              <strong>{{ $errors->first('actualtime') }}</strong>
            </span>
        @endif
      </div>
    </div>

          <div class="col-xs-6">
            <div class="form-group {{ $errors->has('dayreality') ? ' has-error' : '' }}">
            <label for="ex3">{{ __('transport::app.dayreality') }}</label>
            <input name="dayreality" type="text" class="form-control hijri-datepicker-input">
        @if ($errors->has('dayreality'))
            <span class="help-block">
              <strong>{{ $errors->first('dayreality') }}</strong>
            </span>
        @endif
      </div>
    </div>

          <div class="col-xs-6">
            <div class="form-group {{ $errors->has('track') ? ' has-error' : '' }}">
            <label for="ex3">{{ __('transport::app.Line_affected') }}</label>

                <select class="form-control edited" id="form_control_1" name="track" >
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

        <div class="col-xs-12">
          <div class="form-group {{ $errors->has('attachment') ? ' has-error' : '' }}">
          <label for="ex3">{{ __('transport::app.Attachments') }}</label>
          <input name="attachment"  class="form-control" id="ex3" type="file" >
        @if ($errors->has('attachment'))
            <span class="help-block">
              <strong>{{ $errors->first('attachment') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="col-xs-6">
          <div class="form-group {{ $errors->has('attachment') ? ' has-error' : '' }}">
          <br>
          <input type="submit" class="btn btn-primary btn-md"
                                 value="{{ __('transport::app.save')}}" >
         </div>
    </div>



    </div>





    </form>

</div>




@stop
