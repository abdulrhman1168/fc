@if (App::getLocale() == "ar")
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  {{ Html::style(mix('assets/css/fonts.css')) }}
  {{ Html::style(mix('assets/css/main_ar.css')) }}
  <!-- END GLOBAL MANDATORY STYLES -->

  <!-- BEGIN PAGE LEVEL PLUGINS -->
  @yield('styles')
  <!-- END PAGE LEVEL PLUGINS -->

  <!-- BEGIN THEME GLOBAL STYLES -->
  {{ Html::style(mix('assets/css/global_ar.css')) }}
  <!-- END THEME GLOBAL STYLES -->

  <!-- BEGIN THEME LAYOUT STYLES -->
  {{ Html::style(mix('assets/css/layout_ar.css')) }}
  <!-- END THEME LAYOUT STYLES -->

  {{ Html::style('https://fonts.googleapis.com/css?family=Cairo:400,600,700,900&amp;subset=arabic') }}

  <link href="assets/img/favicon.ico" rel="shortcut icon">
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

  <!-- BEGIN THEME LAYOUT STYLES -->
  {{ Html::style(mix('assets/css/layout_en.css')) }}
  <!-- END THEME LAYOUT STYLES -->
@endif

{{ Html::style(mix('assets/css/mu.edu.css')) }}