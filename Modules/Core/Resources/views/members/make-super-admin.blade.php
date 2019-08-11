@extends('layouts.main.index')

@section('page')

    {!! Form::open(['route' => ['user_superadmin', $userData->user_id], 'method' => 'put']) !!}

        <div class="panel panel-default">
            <div class="panel-heading">{{ __('core::app.actionConfirmation') }}</div>
        
            <div class="panel-body">
                @if($userData->is_super_admin == 1)
                    {{ __('core::app.removeUserSuperAdminMessage') }} <b>{{ app()->getLocale() == 'ar' ? $userData->user_name : $userData->user_enname }}</b>؟
                @else 
                    {{ __('core::app.addUserSuperAdminMessage') }} <b>{{ app()->getLocale() == 'ar' ? $userData->user_name : $userData->user_enname }}</b>؟
                @endif
            </div>
        
            <div class="panel-footer">
                <button type="submit" class="btn btn-danger">{{ __('core::app.yesBtn') }}</button>
                <a href="{{url('core/users')}}" class="btn btn-default">{{ __('core::app.noBtn') }}</a>
            </div>
        </div>

    {!! Form::close() !!}

@endsection