@extends('layouts.main.index')



@section('page')

@include('transport::activities.flash-message')
<home lang= "{{app()->getLocale()}}"></home>
 @stop
