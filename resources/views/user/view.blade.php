@extends('layouts.app')

@section('page-title', $user->present()->nameOrEmail)

@section('content')

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <h3 class="page-header"><i class="fa fa-user"></i> {{ $user->present()->nameOrEmail }}</h3>
    </div>
</div>


<div class="row">
    <div class="col-lg-4 col-md-5 col-xs-12">
        <section class="panel">
            <header class="panel-heading">
                @lang('app.details')
            </header>
            <div class="panel-body">
                <div class="profile-info panel-profile">
                    <div class="image">
                        <img alt="image" class="follow-avatar" src="{{ $user->present()->avatar }}">
                    </div>
                    <div class="name"><strong>{{ $user->present()->name }}</strong></div>
                    @if ($socialNetworks)
                        <div class="icons">
                            @if ($socialNetworks->facebook)
                                <a href="{{ $socialNetworks->facebook }}" class="btn btn-facebook">
                                    <i class="fa fa-facebook"></i> Facebook
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="3">@lang('app.contact_informations')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>@lang('app.email')</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                        </tr>
                        @if ($user->phone)
                            <tr>
                                <td>@lang('app.phone')</td>
                                <td><a href="telto:{{ $user->phone }}">{{ $user->phone }}</a></td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th colspan="3">@lang('app.additional_informations')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>@lang('app.birth')</td>
                        <td>{{ $user->present()->birthday }}</td>
                    </tr>
                    <tr>
                        <td>@lang('app.last_logged_in')</td>
                        <td>{{ $user->present()->lastLogin }}</td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </section>
    </div>

    <div class="col-lg-8 col-md-7 col-xs-12">
        <section class="panel">
            <header class="panel-heading">
                @lang('app.latest_activity')
                <div class="pull-right">
                    <a href="{{ route('activity.user', $user->id) }}" class="edit"
                       data-toggle="tooltip" data-placement="top" title="@lang('app.complete_activity_log')">
                        @lang('app.view_all')
                    </a>
                </div>
            </header>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>@lang('app.action')</th>
                            <th>@lang('app.date')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userActivities as $activity)
                            <tr>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

@stop