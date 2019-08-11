@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')

<div class="panel-heading">
        {{ __('transport::app.add-driver') }}
</div>
    <add-driver lang= "{{app()->getLocale()}}"></add-driver>
@endsection