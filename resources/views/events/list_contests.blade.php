@extends('layouts.app')

@section('page-title', trans('app.contests'))

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h3 class="page-header"><i class="icon_genius"></i> 
              @lang('app.contests') 
              @if(session('branch_office'))
              - Sucursal: {{ session('branch_office')->name }}
              @endif
            </h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
                <header class="panel-heading">
                   @lang('app.contests_actives')
                </header>
                <div class="panel-body">

                     <table class="table table-default">
                          <thead>
                          <tr>
                              <th>@lang('app.name')</th>
                              <th>@lang('app.description')</th>
                              <th class="text-center">@lang('app.actions')</th>
                          </tr>
                          </thead>
                          <tbody>
                          @if (count($events) > 0)
                              @foreach ($events as $event) 
                                  <tr>
                                      <td>{{ $event->name }}</td>
                                      <td>{{ $event->description }}</td>
                                      <td class="text-center">
  
                                          <a href="{{ route('event.show.participants', $event->id) }}" class="btn btn-success">
                                              @lang('app.show_participants')
                                          </a>
  
                                      </td>
                                  </tr>
                              @endforeach
                          @else
                              <tr>
                                  <td colspan="3"><em>@lang('app.no_records_found')</em></td>
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
    </script>
@stop
