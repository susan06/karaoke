      <!--header start--> 
      <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <!--logo start-->
            <a href="{{route('dashboard')}}" class="logo">Bar<span class="lite">Karaoke</span></a>
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
                            <li class="eborder-top">
                                <a href="{{ route('profile') }}"><i class="icon_profile"></i> @lang('app.my_profile')</a>
                            </li>
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