@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')

    <dailymovment-index></dailymovment-index>
@endsection