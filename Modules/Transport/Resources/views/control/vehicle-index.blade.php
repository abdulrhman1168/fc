@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')

<div class="panel-heading">
        {{ __('transport::app.add_vehicle') }}
</div>
    <add-vehicle></add-vehicle>
@endsection