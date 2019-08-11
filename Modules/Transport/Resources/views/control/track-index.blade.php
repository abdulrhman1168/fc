@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')

<div class="panel-heading">
        {{ __('transport::app.add_track') }}
</div>
    <add-track lang= "{{app()->getLocale()}}"></add-track>
@endsection