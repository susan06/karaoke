@extends('layouts.app')

@section('page-title', trans('app.activity_log'))

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h3 class="page-header"><i class="fa fa-user"></i> @lang('app.activity_log')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
                <header class="panel-heading">
                   {{ isset($user) ? $user->present()->nameOrEmail : trans('app.activity_log') }}
                </header>
                <div class="panel-body">

                    <form method="GET" action="" accept-charset="UTF-8">
                      <div class="form-group">
                          <div class="col-lg-10 col-sm-8 col-xs-12">
                              <div class="row">
                                  <div class="col-lg-6 col-sm-6 col-xs-12 margin_search">
                                      <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search')">
                                  </div>
                                  <div class="btns-search">
                                      <button type="submit" class="btn btn-primary">@lang('app.find')</button>
                                       @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('activity.index') }}" class="btn btn-danger">
                                            <i class="icon_close_alt2"></i>
                                        </a>
                                       @endif
                                  </div>
                              </div>

                          </div>
                      </div>
                    </form>
                   <div class="table-responsive">                 
                       <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('app.user')</th>
                                <th>@lang('app.ip_address')</th>
                                <th>@lang('app.message')</th>
                                <th>@lang('app.log_time')</th>
                                <th class="text-center">@lang('app.more_info')</th>
                            </tr>
                            </thead>
                            <tbody>
                             @foreach ($activities as $activity)
                                <tr>
                                    <td>
                                        @if (isset($user))
                                            {{ $activity->user->present()->nameOrEmail }}
                                        @else
                                            <a href="{{ route('activity.user', $activity->user_id) }}"
                                                data-toggle="tooltip" title="@lang('app.view_activity_log')">
                                                {{ $activity->user->present()->nameOrEmail }}
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $activity->ip_address }}</td>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="text-center">
                                        <a tabindex="0" role="button" class="btn btn-primary"
                                           data-trigger="focus"
                                           data-placement="left"
                                           data-toggle="popover"
                                           title="@lang('app.user_agent')"
                                           data-content="{{ $activity->user_agent }}">
                                            <i class="fa fa-info"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach                                                      
                            </tbody>
                       </table>
                    </div>
                   {!! $activities->render() !!}
                </div>
            </section>

        </div>
    </div>
  <!-- page end-->
@stop
