@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

 <!--Breadcrumb-->
  <div class="breadcrumb clearfix">
    <ul>
      <li><a href="{{ route('dashboard') }}"><i class="fa fa-home fa-2x"></i></a></li>
      <li class="active">@lang('app.dashboard')</li>
    </ul>
  </div>
  <!--/Breadcrumb-->

<div class="page-header">
    <h1>@lang('app.welcome')<small>{{ Auth::user()->username ?: Auth::user()->first_name }}</small></h1>
</div>

  <!-- Widget Row Start grid -->
<div class="row">

      <div class="col-md-3 col-sm-6 bootstrap-grid">        
        <!-- New widget -->
        <div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-cold-grey"  data-widget-editbutton="false">
          <header> </header>
          <div class="inner-spacer nopadding">
            <div class="portlet-big-icon"><i class="fa fa-user"></i></div>
            <ul class="portlet-bottom-block">
              <li class="col-md-12 col-sm-12 col-xs-12"><a href="{{ route('profile') }}" class="panel-link"><strong>@lang('app.update_profile')</strong></a></li>
            </ul>
          </div>
        </div>
        <!-- /New widget --> 
      </div>

      <div class="col-md-3 col-sm-6 bootstrap-grid"> 
            
            <!-- New widget -->
            <div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-blue"  data-widget-editbutton="false">
              <header> </header>
              <div class="inner-spacer nopadding">
                <div class="portlet-big-icon"><i class="fa fa-list"></i></div>
                <ul class="portlet-bottom-block">
                  <li class="col-md-12 col-sm-12col-xs-12"><a href="{{ route('profile.sessions') }}" class="panel-link"><strong>@lang('app.my_sessions')</strong></a></li>
                </ul>
              </div>
            </div>
            <!-- /New widget --> 
            
      </div>
      <!-- /Inner Row Col-md-3 -->
      
      <div class="col-md-3 col-sm-6 bootstrap-grid"> 
        
        <!-- New widget -->
        <div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-green" data-widget-editbutton="false">
          <header> </header>
          <div class="inner-spacer nopadding">
            <div class="portlet-big-icon"><i class="fa fa-list-alt"></i></div>
            <ul class="portlet-bottom-block">
              <li class="col-md-12 col-sm-12 col-xs-12"><a href="{{ route('profile.activity') }}" class="panel-link"><strong>@lang('app.activity_log')</strong></a></li>
            </ul>
          </div>
        </div>
        <!-- /New widget --> 
        
      </div>
      <!-- /Inner Row Col-md-3 -->
      
      <div class="col-md-3 col-sm-6 bootstrap-grid"> 
        
        <!-- New widget -->
        <div class="powerwidget powerwidget-as-portlet powerwidget-as-portlet-red"data-widget-editbutton="false">
          <header> </header>
          <div class="inner-spacer nopadding">
            <div class="portlet-big-icon"><i class="fa fa-sign-out"></i></div>
            <ul class="portlet-bottom-block">
              <li class="col-md-12 col-sm-12 col-xs-12"> <a href="{{ route('auth.logout') }}" class="panel-link"><strong>@lang('app.logout')</strong></a></li>
            </ul>
          </div>
        </div>
        <!-- /New widget --> 
        
      </div>
    <!-- /Inner Row Col-md-3 -->
    <div class="clearfix"></div>
  <!-- /Inner Row Col-md-12 --> 
</div>
<!-- /Widgets Row End Grid-->  

 <!-- Widget Row Start grid -->
  <div class="row">

    <!-- /Inner Row Col-md-6 -->
    
    <div class="col-md-12 bootstrap-grid"> 
    
      <div class="col-md-12">
        <!-- New widget -->
        <div class="powerwidget" data-widget-editbutton="false">
          <header>
            <h2>@lang('app.activity') (@lang('app.last_two_weeks'))</h2>
          </header>
          <div class="inner-spacer">
            <div class="flotchart-block">
              <div class="flotchart-container">
                <canvas id="myChart" height="403"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /Inner Row Col-md-12 --> 
  </div>
  <!-- /Widgets Row End Grid--> 
@stop

@section('scripts')
    <script>
        var labels = {!! json_encode(array_keys($activities)) !!};
        var activities = {!! json_encode(array_values($activities)) !!};
    </script>
    {!! HTML::script('assets/js/chart.min.js') !!}
    {!! HTML::script('assets/js/as/dashboard-default.js') !!}
@stop