@if($status == '1')
<a href="{{ route('trans.daily-reports.edit', ['id' => $id])  }}" class="btn  btn-info">
  <i class="fa fa-pencil"></i> {{ __('messages.action_edit') }}
</a>
@endif


<a href="{{ route('trans.daily-reports.show', ['id' => $id]) }}" class="btn  btn-default">
  <i class="fa fa-eye"></i>{{ __('messages.action_show') }}
</a>
<form method="post" action="{{route('daily-reports.destroy', ['id' => $id])}}">
      <input type="hidden" name="_method" value="delete" />
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <button type="submit" class="btn btn-danger" >  <i class="fa fa-close">{{ __('messages.action_delete') }}</i> </button>
</form>
