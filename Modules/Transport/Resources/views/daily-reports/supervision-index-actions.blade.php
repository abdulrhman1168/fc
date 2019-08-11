@if($status == '1')
{{__('transport::app.evulated-done')}}
@else
<a href="{{ route('trans.supervision-reports.evaluate', ['id' => $id]) }}" class="btn  btn-success">
  <i class="fa fa-eye"></i>{{ __('transport::app.evaluate') }}
</a>
@endif