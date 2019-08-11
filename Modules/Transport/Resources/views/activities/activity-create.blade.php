@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')

    <create-activity></create-activity>
@endsection