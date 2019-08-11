@extends('layouts.main.index')

@section('page')

  @if($permissionableType == "users")
    <h2><i class="fa fa-user"></i> {{$model->user_name}}</h2>
  @elseif($permissionableType == "groups")
    <h2><i class="fa fa-users"></i> {{$model->name}}</h2>
  @endif

  <core-app-wrapper permission-route-url="{{$routeUrl}}"
                    is-permission=true
                    permissionable-type="{{ $permissionableType }}"
                    permissionable-id="{{ $permissionableId }}">
  </core-app-wrapper>
@endsection
