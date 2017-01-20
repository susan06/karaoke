@extends('layouts.app')

@section('page-title', trans('app.events'))

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h3 class="page-header"><i class="icon_genius"></i> @lang('app.events')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
                <header class="panel-heading">
                   @lang('app.list_of_registered_events')
                </header>
                <div class="panel-body">

                    <form method="GET" action="" accept-charset="UTF-8" id="event-form">
                      <div class="form-group">
                          <div class="col-lg-10 col-sm-12 col-xs-12">
                              <div class="row">
                                  <div class="col-lg-4 col-sm-4 col-xs-4 margin_search">
                                      {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
                                  </div>
                                  <div class="col-lg-4 col-sm-4 col-xs-4 margin_search">
                                    {!! Form::select('branch_office_id', $branch_offices, Input::get('branch_office_id'), ['id' => 'branch_offices', 'class' => 'form-control']) !!}
                                </div>

                                  <div class="col-lg-4 col-sm-4 col-xs-4 margin_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_event')">
                                        
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
                                             @if (Input::has('search') && Input::get('search') != '')
                                              <a href="{{ route('event.index') }}" class="btn btn-danger">
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
                       <a href="{{ route('event.create') }}" class="btn btn-primary" id="add-event">
                          <i class="fa fa-plus"></i>
                          @lang('app.add_event')
                      </a>
                      </div>

                       <table class="table table-default">
                            <thead>
                            <tr>
                                <th>@lang('app.branch_office')</th>
                                <th>@lang('app.name')</th>
                                <th>@lang('app.description')</th>
                                <th>@lang('app.registration_date')</th>
                                <th>@lang('app.status')</th>
                                <th class="text-center">@lang('app.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($events))
                                @foreach ($events as $event) 
                                    <tr>
                                        <td>{{ ($event->branch_office_id) ? $event->branch_office->name : '' }}</td>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ $event->description }}</td>
                                        <td>{{ $event->created_at }}</td>
                                        <td>
                                            {!!$event->labelStatus() !!}
                                        </td>
                                        <td class="text-center">
                                        @if($event->status == 'start')
                                            <a href="{{ route('event.add.client', $event->id) }}" class="btn btn-primary btn-sm btn-xs">
                                                @lang('app.add_clients_event')
                                            </a>
                                        @endif
                                        
                                            <a href="{{ route('event.show.votes', $event->id) }}" class="btn btn-success btn-sm btn-xs">
                                                @lang('app.show_votes')
                                            </a>
    
                                            <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm btn-xs edit" title="@lang('app.edit_event')"
                                                  data-toggle="tooltip" data-placement="top">
                                              <i class="fa fa-pencil"></i>
                                            </a>

                                            <a href="javascript:void(0)" class="btn btn-sm btn-xs btn-danger btn-delete" title="@lang('app.delete_event')"
                                                    data-href="{{ route('event.delete') }}"
                                                    data-id="{{ $event->id }}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-confirm-title="@lang('app.please_confirm')"
                                                    data-confirm-text="@lang('app.are_you_sure_delete_event')"
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
               
                   {!! $events->render() !!}
                </div>
            </section>

        </div>
    </div>
  <!-- page end-->
@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#event-form").submit();
        });
        $("#branch_offices").change(function () {
            $("#event-form").submit();
        });
    </script>
@stop
