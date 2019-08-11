@extends('layouts.main.index')

@section('page')
  <div class="alert alert-danger">
    <strong>{{ __('messages.unauthorized_user') }}</strong>
  </div>
@endsection
