<div class="page-wrapper" id="vue-app">
          <!-- BEGIN HEADER -->
          <div class="page-header navbar navbar-fixed-top">
              <!-- BEGIN HEADER INNER -->
              <div class="page-header-inner">
                  <!-- BEGIN LOGO -->
                  <div class="page-logo">
                    <br />
                      <a href="/">
                          {{ __('messages.app_name') }}
                          {{-- <img src="#" alt="{{ __('messages.app_name') }}" class="logo-default" /> --}}
                      </a>
                      <div id="menu-toggler-sidebar-btn" class="menu-toggler sidebar-toggler">
                          <span></span>
                      </div>
                  </div>
                  <!-- END LOGO -->
                  <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                  {{-- <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                      <span></span>
                  </a> --}}
                  <!-- END RESPONSIVE MENU TOGGLER -->
                  <!-- BEGIN TOP NAVIGATION MENU -->
                  @include('layouts.main.top-menu')
                  <!-- END TOP NAVIGATION MENU -->
              </div>
              <!-- END HEADER INNER -->
          </div>
          <!-- END HEADER -->
          <!-- BEGIN HEADER & CONTENT DIVIDER -->
          <div class="clearfix"> </div>
          <!-- END HEADER & CONTENT DIVIDER -->
          <!-- BEGIN CONTAINER -->
          <div class="page-container">
              <!-- BEGIN SIDEBAR -->
              <div class="page-sidebar-wrapper">
                  <!-- BEGIN SIDEBAR -->
                  <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                  <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                  <div class="page-sidebar navbar-collapse collapse">
                      @include('layouts.main.side-menu')
                  </div>
                  <!-- END SIDEBAR -->
              </div>
              <!-- END SIDEBAR -->
              <!-- BEGIN CONTENT -->
              <div class="page-content-wrapper">
                  <!-- BEGIN CONTENT BODY -->
                  <div class="page-content">
                      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <div class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</div>
                            @endif
                      @endforeach

                      @if ($errors->any())
                          <div class="alert alert-danger">
                              {{-- <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul> --}}
                              {{ __('messages.review_errors') }}
                          </div>
                      @endif
                      @if($errors->has('general_error'))
                        <div class="alert alert-danger">
                                <strong>{{ $errors->first('general_error') }}</strong>
                        </div>
                      @endif
                      @yield('page')

                      <div class="clearfix"></div>
                      <!-- END DASHBOARD STATS 1-->

                  </div>
                  <!-- END CONTENT BODY -->
              </div>
              <!-- END CONTENT -->
              <!-- BEGIN QUICK SIDEBAR -->
              <a href="javascript:;" class="page-quick-sidebar-toggler">
                  <i class="icon-login"></i>
              </a>

              <!-- END QUICK SIDEBAR -->
          </div>
          <!-- END CONTAINER -->
          <!-- BEGIN FOOTER -->
          <div class="page-footer">
              <div class="page-footer-inner">
                  <a target="_blank" href=""></a> &nbsp;|&nbsp;
              </div>
              <div class="scroll-to-top">
                  <i class="icon-arrow-up"></i>
              </div>
          </div>
          <!-- END FOOTER -->
      </div>
