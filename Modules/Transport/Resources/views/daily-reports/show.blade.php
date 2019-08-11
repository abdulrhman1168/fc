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
               </div>
              <div class="panel-footer">
                  <a href="{{ route('trans.daily-reports.index') }}" class="btn btn-success">
                    <i class="fa fa-list"></i>
                    {{ __('transport::app.reports_list')}}
                  </a>

                  <a href="{{ route('trans.daily-reports.edit', ['id' => $dailyReport->id]) }}" class="btn btn-primary">
                    <i class="fa fa-pencil"></i>
                    {{ __('messages.action_edit')}}
                  </a>
              </div>
          </div>
      </div>
  </div>

@endsection
