@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')

<div class="panel-heading">
        {{ __('transport::app.add_district') }}
</div>
    <add-district lang= "{{app()->getLocale()}}"></add-district>
@endsection