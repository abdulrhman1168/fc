@extends('layouts.main.index')

@section('page')
  <div class="panel panel-info">
      <div class="panel-heading">
        {{__('transport::app.add_report') }}
      </div>
      <div class="panel-body">
          {!! Form::model($dailyReport,['route' =>  ['trans.daily-reports.store'],'method'=>'post' ]) !!}

            @include('transport::daily-reports.form')

          <input type="submit" class="btn btn-lg blue" value="{{ __('messages.save') }}" />
          {!! Form::close() !!}

      </div>
  </div>
@endsection
