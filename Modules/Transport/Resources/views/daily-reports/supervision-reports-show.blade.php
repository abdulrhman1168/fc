@extends('layouts.main.index')

@section('page')
    <show-supervision-report lang= "{{app()->getLocale()}}"> </show-supervision-report>

@endsection
