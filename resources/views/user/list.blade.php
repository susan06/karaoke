@extends('layouts.app')

@section('page-title', trans('app.users'))

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h3 class="page-header"><i class="fa fa-user"></i> @lang('app.users')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
                <header class="panel-heading">
                   @lang('app.list_of_registered_users')
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
                                        <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_users')">
                                        
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
                     <div class="col-md-2 pull-right">
                       <a href="{{ route('user.create') }}" class="btn btn-primary" id="add-user">
                          <i class="fa fa-plus"></i>
                          @lang('app.add_user')
                      </a>
                      </div>

                    <div class="table-responsive">
                       <table class="table">
                            <thead>
                            <tr>
                                <th>@lang('app.username')</th>
                                <th>@lang('app.full_name')</th>
                                <th>@lang('app.email')</th>
                                <th>@lang('app.role')</th>
                                <th>@lang('app.registration_date')</th>
                                <th>@lang('app.status')</th>
                                <th class="text-center">@lang('app.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($users))
                                @foreach ($users as $user) 
                                    <tr>
                                        <td>{{ $user->username ?: trans('app.n_a') }}</td>
                                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->roles->first()->display_name }}</td>
                                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <span class="label label-{{ $user->present()->labelClass }}">{{ trans("app.{$user->status}") }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if (config('session.driver') == 'database')
                                                <a href="{{ route('user.sessions', $user->id) }}" class="btn btn-primary"
                                                   title="@lang('app.user_sessions')" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-list"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('user.show', $user->id) }}" class="btn btn-success"
                                               title="@lang('app.view_user')" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning edit" title="@lang('app.edit_user')"
                                                  data-toggle="tooltip" data-placement="top">
                                              <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-delete" title="@lang('app.delete_user')"
                                                    data-href="{{ route('user.delete') }}"
                                                    data-id="{{$user->id}}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-confirm-title="@lang('app.please_confirm')"
                                                    data-confirm-text="@lang('app.are_you_sure_delete_user')"
                                                    data-confirm-delete="@lang('app.yes_delete_him')">
                                                <i class="icon_close_alt2"></i>
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
