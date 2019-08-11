@extends('layouts.main.index')

@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-users"></i>
          <span class="caption-subject sbold uppercase">{{ __('transport::app.daily_report') }}</span>
        </div>
        <div class="actions">
          <div class="btn-group btn-group-devided" data-toggle="buttons">
              <a href="{{ route('trans.daily-reports.create') }}" class="btn btn-success">{{ __('messages.action_add')}}</a>
          </div>
        </div>
      </div>
      <table id="table-ajax" class="table panel-body delete-object-modal-table"
             data-url="/transport/daily-reports"
             data-fields='[
                 {"data": "report_date","title":"{{ __('transport::app.report_date') }}","searchable":"true"},
                 {"data": "status","title":"{{ __('transport::app.status') }}","searchable":"false"},
                 {"data": "action","name":"actions","searchable":"false", "orderable":"false"}
             ]'>
           </table>
  </div>

@endsection
