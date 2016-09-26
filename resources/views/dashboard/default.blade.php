@extends('layouts.app')

@section('page-title', trans('app.dashboard'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Dashboard</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="{{route('dashboard')}}">Home</a></li>
              <li><i class="fa fa-laptop"></i>Dashboard</li>                
            </ol>
        </div>
    </div>

  <!-- page start-->
  Page content goes here
  <!-- page end-->
@stop
