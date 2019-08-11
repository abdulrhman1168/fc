@extends('layouts.main.index')

@section('page')
  <div class="panel panel-default">
      <div class="panel-heading">{{ __('messages.users') }}</div>

      <table id="table-ajax" class="table panel-body"
             data-url="/core/users"
             data-fields='[
                 {"data": "user_id","title":"{{ __('messages.user_id') }}","searchable":"true"},
                 {"data": "user_empno","title":"{{ __('messages.user_empno') }}","searchable":"true"},
                 {"data": "user_name","title":"{{ __('messages.user_name') }}","searchable":"true"},
                 {"data": "user_mail","title":"{{ __('messages.email') }}","searchable":"true"},
                 {"data": "user_idno","title":"{{ __('messages.user_idno') }}","searchable":"true"},
                 {"data": "action","name":"actions","searchable":"false", "orderable":"false"}
             ]'>
           </table>
  </div>

@endsection
