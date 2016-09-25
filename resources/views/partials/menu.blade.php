  <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
               <!--sidebar menu start-->
              <ul class="sidebar-menu">                
                  @if (true) <!--Auth::user()->hasRole('admin')-->
                  <li class="">
                      <a class="" href="{{route('dashboard')}}">
                          <i class="icon_house_alt"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
				          <li class="">
                      <a href="#" class="">
                          <i class="fa fa-user"></i>
                          <span>@lang('app.users')</span>
                      </a>
                  </li>        
                  <li class="">
                      <a href="#" class="">
                          <i class="fa fa-users"></i>
                          <span>@lang('app.clients')</span>
                      </a>
                  </li> 
                  <li class="sub-menu">
                      <a href="#" class="">
                          <i class="fa fa-bars"></i>
                          <span>@lang('app.activity_log')</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="fa fa-play-circle"></i>
                          <span>@lang('app.songs')</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="#">@lang('app.popular_songs')</a></li>
                          <li><a class="" href="#">@lang('app.requested_songs')</a></li>
                      </ul>
                  </li>
                  <li class="">
                      <a href="#" class="">
                          <i class="fa fa-check-circle"></i>
                          <span>@lang('app.reservations')</span>
                      </a>
                  </li>
                   <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="fa fa-cogs"></i>
                          <span>@lang('app.settings')</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="#">@lang('app.general')</a></li>
                          <li><a class="" href="#">@lang('app.background')</a></li>
                      </ul>
                  </li>
                  @endif  
                  @if (false) <!--Auth::user()->hasRole('user')-->
                  <li class="">
                      <a href="{{route('song.search')}}" class="">
                          <i class="fa fa-play-circle"></i>
                          <span>@lang('app.ask_song')</span>
                      </a>
                  </li>
                  <li class="">
                      <a href="{{route('song.my_list')}}" class="">
                          <i class="fa fa-bars"></i>
                          <span>@lang('app.my_list')</span>
                      </a>
                  </li>
                  <li class="">
                      <a href="{{route('song.ranking')}}" class="">
                          <i class="fa fa-play-circle"></i>
                          <span>@lang('app.most_requested')</span>
                      </a>
                  </li>
                   <li class="">
                      <a href="{{route('song.search.advanced')}}" class="">
                          <i class="fa fa-search"></i>
                          <span>@lang('app.advanced_search')</span>
                      </a>
                  </li>
                  <li class="">
                      <a href="#" class="">
                          <i class="fa fa-check-circle"></i>
                          <span>@lang('app.reservation_table')</span>
                      </a>
                  </li>
                  @endif      
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
