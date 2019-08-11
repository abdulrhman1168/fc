<!DOCTYPE html>
@if (App::getLocale() == "ar")
  <html lang="{{ app()->getLocale() }}" dir="rtl">
@else
  <html lang="{{ app()->getLocale() }}" dir="ltr">
@endif
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{--CSRF Token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>

        {{--Title--}}
        <title>{{ __('app.eservicesApp') }} @yield('title')</title>

        {{--Common App Styles--}}
         @include('layouts.main.css')
         <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">

        {{--Head--}}
        @yield('head')

    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

        {{--Page--}}
        @include('layouts.main.main_wrapper')

        @include('layouts.main.js')
    </body>
    
</html>
