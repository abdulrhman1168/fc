@extends('layouts.login.index')

@section('page_title')
  {{ __('messages.sign_in') . ' | ' .  __('messages.maj_university')}}
@endsection

@section('page')
  <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index.html">
                <img src="/assets/img/mu-login-logo.png" alt="" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            {{ Form::open(['route' => 'auth', 'class' => 'login-form', 'method' => 'post']) }}
                <h3 class="form-title font-green">{{ __('messages.sign_in')}}</h3>
                @if (session('error_login'))
                  <div class="alert alert-danger">
                      <button class="close" data-close="alert"></button>
                      <span>{{ __('messages.login_error_message') }}</span>
                  </div>
                @endif
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label">{{ __('messages.username') }}</label>
                    {{ Form::text('username', old('username') , ['class' => 'form-control form-control-solid placeholder-no-fix',
                                                     'required' => true,
                                                     'placeholder' => __('messages.username')]) }}
                  </div>
                <div class="form-group">
                    <label class="control-label">{{ __('messages.password') }}</label>
                    {{ Form::password('password', ['class' => 'form-control form-control-solid placeholder-no-fix',
                                                     'required' => true,
                                                     'placeholder' => __('messages.password')]) }}
               </div>
                <div class="form-actions">
                    {{Form::submit(__('messages.sign_in'), ['class' => 'btn green uppercase'])}}
                    {{-- <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" />Remember
                        <span></span>
                    </label>
                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> --}}
                </div>
            {!! Form::close() !!}
            <!-- END LOGIN FORM -->


        </div>
        <div class="copyright">   {{  __('messages.maj_university')}} © {{ date('Y') }} </div>
@endsection
