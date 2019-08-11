@if (App::getLocale() == "ar")
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  {{ Html::style(mix('assets/css/main_ar.css')) }}
  <!-- END GLOBAL MANDATORY STYLES -->

  <!-- BEGIN PAGE LEVEL PLUGINS -->
  @yield('styles')
  <!-- END PAGE LEVEL PLUGINS -->

  <!-- BEGIN THEME GLOBAL STYLES -->
  {{ Html::style(mix('assets/css/global_ar.css')) }}
  <!-- END THEME GLOBAL STYLES -->

  {{ Html::style(mix('assets/css/login_ar.css')) }}

@else
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  {{ Html::style(mix('assets/css/main_en.css')) }}
  <!-- END GLOBAL MANDATORY STYLES -->

  <!-- BEGIN PAGE LEVEL PLUGINS -->
  @yield('styles')
  <!-- END PAGE LEVEL PLUGINS -->

  <!-- BEGIN THEME GLOBAL STYLES -->
  {{ Html::style(mix('assets/css/global_en.css')) }}
  <!-- END THEME GLOBAL STYLES -->

  {{ Html::style(mix('assets/css/login.css')) }}

@endif
