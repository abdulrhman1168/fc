<table class='table table-bordered table-hover'>
  <tbody>
    <tr>
      <th width="20%">{{ __('transport::app.reporter_name') }}</th>
      <td>{{ $dailyReport->reporter->user_name }}</td>
    </tr>
    <tr>
      <th width="20%">{{ __('transport::app.destination') }}</th>
      <td>{{ optional($dailyReport->reporter->department())->name }}</td>
    </tr>
    <tr>
      <th width="20%">{{ __('transport::app.report_date') }}</th>
      <td>{{ $dailyReport->report_date->format('Y-m-d') }}</td>
    </tr>
    <tr>
      <th>{{ __('transport::app.status') }}</th>
      <td>{{ $dailyReport->status == 1 ? __('New') :  __('transport::app.guidance_done')}}</td>
    </tr>
    <tr>
      <th>{{ __('transport::app.report_degree') }}</th>
      <td>{{ $degrees[$dailyReport->degree] }}</td>
    </tr>
    <tr>
      <th>{{ __('transport::app.report_body') }}</th>
      <td>{{ $dailyReport->body }}</td>
    </tr>
    <tr>
      <th>{{ __('transport::app.report_resource') }}</th>
      <td>{{ $dailyReport->report_resource }}</td>
    </tr>
    <tr>
      <th>{{ __('transport::app.action_from_transport_office') }}</th>
      <td>{{ $dailyReport->action_from_transport_office }}</td>
    </tr>
    @if($dailyReport->status == 2)
      <tr>
        <th width="20%">{{ __('transport::app.guidance') }}</th>
        <td>{{  $dailyReport->guidance }}</td>
      </tr>
    @endif
  </tbody>
</table>
