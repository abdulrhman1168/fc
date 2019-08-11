@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')

<div class="panel-heading">
        {{ __('transport::app.send-evaluation') }}
</div>
    <add-supervision-report lang= "{{app()->getLocale()}}"></add-supervision-report>
@endsection