@extends('layouts.main.index')

@section('page')
  <div class="portlet light bordered">
      <div class="portlet-title">
        <div class="caption">
          <i class="fa fa-users"></i>
          <span class="caption-subject sbold uppercase">{{ __('messages.groups') }}</span>
        </div>
        <div class="actions">
          <div class="btn-group btn-group-devided" data-toggle="buttons">
              <a href="{{ route('groups.create') }}" class="btn btn-primary">{{ __('messages.action_add')}}</a>
          </div>
        </div>
      </div>
      <table id="table-ajax" class="table panel-body delete-object-modal-table" data-form="deleteForm"
             data-url="/core/groups"
             data-fields='[
                 {"data": "name","title":"{{ __('messages.general_name') }}","searchable":"true"},
                 {"data": "action","name":"actions","searchable":"false", "orderable":"false"}
             ]'>
           </table>
  </div>

@endsection
