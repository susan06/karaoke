      <!--header start--> 
      <header class="header dark-bg">
            @if (!Auth::user()->hasRole('dj'))
                @if(Auth::user()->hasRole('user') && !Agent::isMobile())
                <div class="toggle-nav">
                    <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
                </div>
                @else
                    <div class="toggle-nav">
                        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
                    </div>
                @endif
            @endif
            <!--logo start-->
            <a href="{{route('dashboard')}}" class="logo">{{Settings::get('app_name')}}</a>
            <!--logo end-->


            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    
                   <!-- user login dropdown start-->
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
                            <li class="eborder-top">
                                <a href="{{route('song.search')}}"><i class="fa fa-play-circle"></i> @lang('app.ask_song')</a>
                            </li>
                            @endif
                            <li class="eborder-top">
                                <a href="{{ route('profile') }}"><i class="icon_profile"></i> @lang('app.my_profile')</a>
                            </li>
                            @if (! Auth::user()->hasRole('user'))
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
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
      </header>      
      <!--header end-->