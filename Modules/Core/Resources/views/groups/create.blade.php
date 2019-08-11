@extends('layouts.main.index')

@section('page')
  <div class="panel panel-info">
      <div class="panel-heading">
        {{ __('messages.add_group') }}
      </div>
      <div class="panel-body">
          {!! Form::model($group,['route' =>  ['groups.store'],'method'=>'post' ]) !!}

            @include('core::groups.form')

          <input type="submit" class="btn btn-lg blue" value="{{ __('messages.save') }}" />
          {!! Form::close() !!}

      </div>
  </div>
@endsection
