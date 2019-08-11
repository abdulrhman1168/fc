@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')
<show-activity :activity="{{$activity}}"></show-activity>

@stop
