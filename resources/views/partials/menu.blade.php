  <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
               <!--sidebar menu start-->
              <ul class="sidebar-menu">                
                @if (Auth::user()->hasRole('superAdmin'))  
                  <li class="{{ Request::is('/') ? 'active' : ''  }}">
                      <a class="" href="{{route('dashboard')}}">
                          <i class="icon_house_alt"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
				          <li class="{{ Request::is('user*') ? 'active' : ''  }}">
                      <a href="{{ route('user.list') }}" class="">
                          <i class="icon_contacts_alt"></i>
                          <span>@lang('app.users')</span>
                      </a>
                  </li> 
                  <li class="{{ Request::is('activity*') ? 'active' : ''  }}">
                      <a href="{{ route('activity.index') }}" class="">
                          <i class="icon_ul"></i>
                          <span>@lang('app.activity_log')</span>
                      </a>
                  </li> 
                  <li class="sub-menu {{ Request::is('songs*') ? 'active' : ''  }}">
                      <a href="javascript:void(0);" class="">
                          <i class="icon_headphones"></i>
                          <span>@lang('app.songs')</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="{{route('song.index')}}">@lang('app.all_songs')</a></li>
                          <li><a class="" href="{{route('song.create')}}">@lang('app.create_song')</a></li>
                          <li><a class="" href="{{route('song.import')}}">@lang('app.import_songs')</a></li>
                      </ul>
                  </li>
                  <li class="{{ Request::is('branch-office*') ? 'active' : ''  }}">
                      <a href="{{ route('branch-office.index') }}" class="">
                          <i class="icon_genius"></i>
                          <span>@lang('app.branch_offices')</span>
                      </a>
                  </li> 
                  <li class="sub-menu {{ Request::is('settings*') ? 'active' : ''  }}">
                      <a href="javascript:void(0);" class="">
                          <i class="icon_cog"></i>
                          <span>@lang('app.settings') </span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="{{route('settings.general')}}">@lang('app.general')</a></li>
                          <li><a class="" href="{{route('settings.background')}}">@lang('app.background')</a></li>
                      </ul>
                  </li>
                @endif   
                @if (Auth::user()->hasRole('admin'))   
                  <li class="{{ Request::is('clients*') ? 'active' : ''  }}">
                      <a href="{{route('user.client.index')}}" class="">
                          <i class="fa fa-user"></i>
                          <span>@lang('app.clients')</span>
                      </a>
                  </li> 
                  <li class="sub-menu {{ Request::is('songs*') ? 'active' : ''  }}">
                      <a href="javascript:;" class="">
                          <i class="icon_headphones"></i>
                          <span>@lang('app.songs')</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="{{route('song.ranking')}}">@lang('app.popular_songs')</a></li>
                          <li><a class="" href="{{route('song.apply.list')}}">@lang('app.requested_songs')</a></li>
                      </ul>
                  </li>
                  <li class="{{ Request::is('reservations*') ? 'active' : ''  }}">
                      <a href="{{route('reservation.adminIndex')}}" class="">
                          <i class="icon_refresh"></i>
                          <span>@lang('app.reservations')</span>
                      </a>
                  </li>
                @endif  
                @if (Auth::user()->hasRole('user'))
                  <li class="">
                      <a href="{{route('song.search')}}" class="">
                          <i class="icon_headphones"></i>
                          <span>@lang('app.ask_song')</span>
                      </a>
                  </li>
                  <li class="">
                      <a href="{{route('song.my_list')}}" class="">
                          <i class="icon_ul"></i>
                          <span>@lang('app.my_list')</span>
                      </a>
                  </li>
                  <li class="">
                      <a href="{{route('song.ranking')}}" class="">
                          <i class="icon_star"></i>
                          <span>@lang('app.most_requested')</span>
                      </a>
                  </li>
                  <li class="sub-menu {{ Request::is('reservations*') ? 'active' : ''  }}">
                      <a href="javascript:void(0);" class="">
                          <i class="icon_refresh"></i>
                          <span>@lang('app.reservations') </span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="{{route('reservation.clientStore')}}">@lang('app.reservation_table')</a></li>
                          <li><a class="" href="{{route('reservation.index')}}">@lang('app.my_reservations')</a></li>
                      </ul>
                  </li>
                @endif      
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
