@extends('layouts.main.index')

@section('page')
  <div class="panel panel-default">
      <div class="panel-heading">{{ __('messages.users') }}</div>

      <table id="table-ajax" class="table panel-body"
             data-url="/core/members"
             data-fields='[
                 {"data": "id","title":"{{ __('messages.user_id') }}","searchable":"true"},
                 {"data": "name","title":"{{ __('messages.user_name') }}","searchable":"true"},
                 {"data": "email","title":"{{ __('messages.email') }}","searchable":"true"},
                 {"data": "mobile","title":"{{ __('messages.mobile') }}","searchable":"true"},
                 {"data": "id_no","title":"{{ __('messages.user_idno') }}","searchable":"true"}
             ]'>
           </table>
  </div>

@endsection
