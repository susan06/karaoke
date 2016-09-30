@extends('layouts.app')

@section('page-title', trans('app.active_sessions'))

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h3 class="page-header"><i class="fa fa-user"></i> @lang('app.active_sessions')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
                <header class="panel-heading">
                   {{ $user->present()->name }}
                </header>
                <div class="panel-body">
                   <table class="table">
                        <thead>
                        <tr>
                            <th>@lang('app.ip_address')</th>
                            <th>@lang('app.user_agent')</th>
                            <th>@lang('app.last_activity')</th>
                            <th class="text-center">@lang('app.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if (count($sessions))
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td>{{ $session->ip_address }}</td>
                                        <td>{{ $session->user_agent }}</td>
                                        <td>{{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->format('Y-m-d H:i:s') }}</td>
                                        <td class="text-center">
                                            <a href="{{ isset($profile) ? route('profile.sessions.invalidate', $session->id) : route('user.sessions.invalidate', [$user->id, $session->id]) }}"
                                                class="btn btn-danger" title="@lang('app.invalidate_session')"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-method="DELETE"
                                                data-confirm-title="@lang('app.please_confirm')"
                                                data-confirm-text="@lang('app.are_you_sure_invalidate_session')"
                                                data-confirm-delete="@lang('app.yes_proceed')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                            @endif                                                     
                        </tbody>
                   </table>
                </div>
            </section>

        </div>
    </div>
  <!-- page end-->
@stop

