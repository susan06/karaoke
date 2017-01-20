@extends('layouts.app')

@section('page-title', trans('app.events'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_genius"></i> 
                {{  trans('app.event').' '.$event->name }}
            </h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.votes_clients')
                </header>
                <div class="panel-body">

                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="row">
                     <table class="table table-default">
                       <thead>
                          <tr>
                              <th>@lang('app.client')</th>
                              <th>@lang('app.total_votes')</th>
                          </tr>
                          </thead>
                          <tbody>
                            @if (count($votes) > 0)
                                @foreach ($votes as $votes => $client) 
                                    <tr>
                                        <td>{!! $client['client'] !!}</td>
                                        <td>{{ $client['votes'] }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                            @endif
                          </tbody>
                     </table>
                    </div>
                  </div>
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->
@stop

