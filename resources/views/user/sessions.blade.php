@extends('layouts.app')

@section('page-title', $user->present()->nameOrEmail . ' - ' . trans('app.active_sessions'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-list"></i> @lang('app.active_sessions')</h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{route('dashboard')}}">Home</a></li>
                <li><i class="fa fa-check-circle"></i><a href="{{route('profile.sessions')}}">  @lang('app.active_sessions')</a></li>
                <li><a href="{{ route('user.show', $user->id) }}"><i class="fa fa-user"></i> {{ $user->present()->name }}</a></li>
            </ol>
        </div>
    </div>

 <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.active_sessions_sm')
                </header>
                <div class="panel-body">
                     <table class="table">
                        <thead>
                            <th>@lang('app.ip_address')</th>
                            <th>@lang('app.user_agent')</th>
                            <th>@lang('app.last_activity')</th>
                            <th class="text-center">@lang('app.action')</th>
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
                                                class="btn btn-danger btn-circle" title="@lang('app.invalidate_session')"
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
