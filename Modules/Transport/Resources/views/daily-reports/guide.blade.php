@extends('layouts.main.index')

@section('page')

  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-success">
              <div class="panel-heading">
                <i class="fa fa-list"></i>
                {{ __('transport::app.daily_report_details') }}
              </div>
               <div class="panel-body">
                 <div class="col-md-12">
                   @include('transport::daily-reports.report_details')
                 </div>


                 <div class="col-md-12">
                   

                   @if($dailyReport->status == 1)

                     {!! Form::model($dailyReport,['route' =>  ['trans.daily-reports.guidance', $dailyReport->id],'method'=>'put' ]) !!}
                       <div class="row">
                         <div class="form-group {{ $errors->has('guidance') ? ' has-error' : '' }}">
                             <label for="name" class="col-md-2 control-label">{{ __('transport::app.guidance') }}</label>

                             <div class="col-md-8">

                                 {!! Form::textarea('guidance',old('guidance'), ['class' => 'form-control']) !!}
                                 @if ($errors->has('guidance'))
                                     <span class="help-block">
                                         <strong>{{ $errors->first('guidance') }}</strong>
                                     </span>
                                 @endif
                             </div>
                         </div>
                       </div>

                     <input type="submit" class="btn btn-lg blue" value="{{ __('transport::app.guidance') }}" />
                     {!! Form::close() !!}
                   @endif

                 </div>
               </div>
              <div class="panel-footer">
                  <a href="{{ route('trans.daily-reports.follow') }}" class="btn btn-success">
                    <i class="fa fa-list"></i>
                    {{ __('transport::app.reports_list')}}
                  </a>
              </div>
          </div>
      </div>
  </div>

@endsection
