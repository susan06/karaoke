@extends('layouts.app')

@section('page-title', trans('app.clients'))

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h3 class="page-header"><i class="fa fa-user"></i> @lang('app.clients')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
                <header class="panel-heading">
                   @lang('app.list_of_registered_clients')
                </header>
                <div class="panel-body">

                    <form method="GET" action="" accept-charset="UTF-8" id="users-form">
                      <div class="form-group">
                          <div class="col-lg-10 col-sm-12 col-xs-12">
                              <div class="row">
                                  <div class="col-lg-4 col-sm-4 col-xs-5 margin_search">
                                      {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
                                  </div>

                                  <div class="col-lg-6 col-sm-6 col-xs-7 margin_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_clients')">
                                        
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
                                             @if (Input::has('search') && Input::get('search') != '')
                                              <a href="{{ route('user.list') }}" class="btn btn-danger">
                                                 <i class="icon_close_alt2"></i>
                                              </a>
                                             @endif
                                        </span>
                                    </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                    </form>
                       <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('app.full_name')</th>
                                <th>@lang('app.email')</th>
                                <th>@lang('app.status')</th>
                                <th class="text-center">@lang('app.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($users))
                                @foreach ($users as $user) 
                                    <tr>
                                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="label label-{{ $user->present()->labelClass }}">{{ trans("app.{$user->status}") }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if (config('session.driver') == 'database')
                                                <a href="{{ route('user.client.sessions', $user->id) }}" class="btn btn-sm btn-xs btn-primary"
                                                   title="@lang('app.user_sessions')" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-list"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('song.my_list', 'user='.$user->id) }}" class="btn btn-sm btn-xs btn-warning"
                                               title="@lang('app.songs')" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-play-circle"></i>
                                            </a>
                                            <a href="{{ route('user.client.show', $user->id) }}" class="btn btn-sm btn-xs btn-success"
                                               title="@lang('app.view_user')" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                            @endif                                                       
                            </tbody>
                       </table>
          
                   {!! $users->render() !!}
                </div>
            </section>

        </div>
    </div>
  <!-- page end-->
@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#users-form").submit();
        });
    </script>
@stop
