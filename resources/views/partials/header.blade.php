      <!--header start--> 
      <header class="header dark-bg">
            @if (Auth::user() && !Auth::user()->hasRole('dj'))
                @if(Auth::user() && Auth::user()->hasRole('user'))
                     @if(!Agent::isMobile())
                        <div class="toggle-nav">
                            <div class="icon-reorder"><i class="icon_menu"></i></div>
                        </div>
                     @endif
                @else
                    <div class="toggle-nav">
                        <div class="icon-reorder"><i class="icon_menu"></i></div>
                    </div>
                @endif
            @endif
  
            <!--logo start-->
            <a href="{{route('dashboard')}}" class="logo">{{Settings::get('app_name')}}</a>
            <!--logo end-->


            <div class="top-nav">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    
                   <!-- user login dropdown start-->
                    @if(Auth::user())
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="profile-ava">
                                    <img alt="user" src="{{ Auth::user()->present()->avatar }}">
                                </span>
                                <span class="username">{{ Auth::user()->present()->nameOrEmail }}</span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu extended logout">
                                <div class="log-arrow-up"></div>
                                @if (Auth::user()->hasRole('dj'))
                                <li class="eborder-top">
                                    <a href="{{route('song.apply.list')}}"><i class="fa fa-play-circle"></i> @lang('app.requested_songs')</a>
                                </li>
                                @endif
                                @if(Agent::isMobile() && Auth::user()->hasRole('user'))
        
                                    @if(session('branch_offices'))
                                        @if(session('branch_office'))
                                            <li class="eborder-top">
                                                <a href="#" onclick="change_branch_office()"><i class="icon_genius"></i> Sucursal: {{ session('branch_office')->name }}</a>
                                            </li>
                                        @endif
                                    @else
                                        @if(session('branch_office'))
                                          <li class="eborder-top">
                                            <a href="#"><i class="icon_genius"></i> Sucursal: {{ session('branch_office')->name }}</a>
                                            </li>
                                        @endif
                                    @endif

                                    <li class="eborder-top">
                                        <a href="{{route('song.search')}}"><i class="fa fa-play-circle"></i> @lang('app.ask_song')</a>
                                    </li>
                                    <li class="">
                                        <a href="{{route('song.my_list')}}"><i class="icon_headphones"></i> @lang('app.my_list')</a>
                                    </li>
                                    <li class="">
                                        <a href="{{route('song.new')}}"><i class="icon_star"></i> @lang('app.new_songs')</a>
                                    </li>
                                    <li class="">
                                        <a href="{{route('reservation.clientStore')}}"><i class="icon_refresh"></i> @lang('app.reservations')</a>
                                    </li>
                                    <li class="">
                                        <a href="{{route('reservation.index')}}"><i class="icon_ul"></i> @lang('app.my_reservations')</a>
                                    </li>
                                    <li class="">
                                        <a href="{{route('event.contests')}}"><i class="icon_ul"></i> @lang('app.contests')</a>
                                    </li>
                                @endif
                                <li class="eborder-top">
                                    <a href="{{ route('profile') }}"><i class="icon_profile"></i> @lang('app.my_profile')</a>
                                </li>
                                @if (!Auth::user()->hasRole('user'))
                                 <li>
                                    <a href="{{ route('profile.sessions') }}">
                                        <i class="fa fa-list"></i>
                                        @lang('app.active_sessions')
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ route('auth.logout') }}"><i class="icon_key_alt"></i> @lang('app.logout')</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="dropdown" style="display: inline-flex;">
                            @if(session('branch_offices'))
                              <a href="javascript::void(0)" class="dropdown-toggle" onclick="change_branch_office()">
                                  <i class="icon_genius"></i>
                                  <span>{{ session('branch_office')->name }}</span>
                              </a>
                            @else
                              @if(session('branch_office'))
                              <a href="javascript::void(0)" class="">
                                  <i class="icon_genius"></i>
                                  <span>{{ session('branch_office')->name }}</span>
                              </a>
                              @endif
                            @endif
                            <a href="{{route('reservation.index')}}" class="">
                                <span>Reservas</span>
                            </a>
                        </li>
                    @endif
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
      </header>      
      <!--header end-->