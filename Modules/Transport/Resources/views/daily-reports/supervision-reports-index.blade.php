@extends('layouts.main.index')

@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-users"></i>
          <span class="caption-subject sbold uppercase">{{ __('transport::app.reports_list') }}</span>
        </div>
    
      </div>
      <table id="table-ajax" class="table panel-body delete-object-modal-table"
             data-url="/transport/reports/supervision"
             data-fields='[
                {"data": "id","title":"{{ __('transport::app.serial') }}","searchable":"false"},
                {"data": "supervisor_name","title":"{{ __('transport::app.supervisor_name') }}","searchable":"true"},

                 {"data": "dateTime","title":"{{ __('transport::app.report_date') }}","searchable":"true"},
                 {"data": "status","title":"{{ __('transport::app.status') }}","searchable":"true"},
                 {"data": "action","name":"actions","searchable":"false", "orderable":"false"}
             ]'>
           </table>
  </div>

@endsection
