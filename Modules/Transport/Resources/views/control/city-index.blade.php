@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')

<div class="panel-heading">
        {{ __('transport::app.add_city') }}
</div>
    <add-city></add-city>
@endsection