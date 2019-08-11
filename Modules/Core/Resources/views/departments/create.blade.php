@extends('layouts.main.index')

@section('page')

    <div class="container mt-5 minhe">
        <div class="row mt-2">
            <div class="col CommityDetails">
                <div class="row">
                    <div class="col CommityTitle p-3 d-flex flex-column justify-content-between">
                        <div class="maintitle d-flex justify-content-between">
                            <h5 class="inPageTitle">إضافة إدارة</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col maindetails p-2 mt-3">

                        {{ Form::open(['route' => 'departments.store', 'class' => 'form-horizontal', 'method' => 'post']) }}

                        @include('core::departments.form')

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
