@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Dashboard</h3>
        </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box blue-bg">
          <i class="fa fa-user"></i>
          <div class="count">{{ $stats['total_clients'] }}</div>
          <div class="title">@lang('app.total_clients')</div>           
        </div><!--/.info-box-->     
      </div><!--/.col-->
      
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box brown-bg">
          <i class="fa fa-group"></i>
          <div class="count">{{ $stats['total'] }}</div>
          <div class="title">@lang('app.total_users')</div>            
        </div><!--/.info-box-->     
      </div><!--/.col-->  
      
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box dark-bg">
          <i class="fa fa-times"></i>
          <div class="count">{{ $stats['banned'] }}</div>
          <div class="title">@lang('app.banned_users')</div>            
        </div><!--/.info-box-->     
      </div><!--/.col-->
      
      <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box green-bg">
          <i class="fa fa-check"></i>
          <div class="count">{{ $stats['unconfirmed'] }}</div>
          <div class="title">@lang('app.unconfirmed_users')</div>            
        </div><!--/.info-box-->     
      </div><!--/.col-->
      
    </div><!--/.row-->

   <div class="row">
      <div class="col-lg-7 col-md-7 col-xs-12">              
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2><i class="fa fa-map-marker red"></i><strong>@lang('app.registration_history')</strong></h2> 
          </div>
          <div class="panel-body-map">
            <canvas id="myChart" height="400"></canvas>
          </div>
        </div>
      </div>
      <div class="col-lg-5 col-md-5 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.latest_registrations')</div>
            <div class="panel-body">
                @if (count($latestRegistrations))
                    <div class="list-group">
                        @foreach ($latestRegistrations as $user)
                        
                            <a href="{{ route('user.show', $user->id) }}" class="list-group-item">
                                <img class="img-circle" src="{{ $user->present()->avatar }}">
                                &nbsp; <strong>{{ $user->present()->nameOrEmail }}</strong>
                                <span class="list-time text-muted small">
                                    <em>{{ $user->created_at->diffForHumans() }}</em>
                                </span>
                            </a>
                        
                        @endforeach
                    </div>
                    <a href="{{ route('user.list') }}" class="btn btn-default btn-block">@lang('app.view_all_users')</a>
                @else
                    <p class="text-muted">@lang('app.no_records_found')</p>
                @endif
            </div>
        </div>
      </div>
   </div>  

@stop

@section('scripts')

    <script>
        var as = {};
        var users = {!! json_encode(array_values($usersPerMonth)) !!};
        var months = {!! json_encode(array_keys($usersPerMonth)) !!};
        var trans = {
            chartLabel: "{{ trans('app.registration_history')  }}",
            new: "{{ trans('app.new_sm') }}",
            user: "{{ trans('app.user_sm') }}",
            users: "{{ trans('app.users_sm') }}"
        };
    </script>
    {!! HTML::script('assets/js/chart.min.js') !!}
    {!! HTML::script('assets/js/as/dashboard-admin.js') !!}
@stop