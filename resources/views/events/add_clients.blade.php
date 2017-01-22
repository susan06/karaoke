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
                   @lang('app.client_register_event')
                </header>
                <div class="panel-body">
                    {!! Form::open(['route' => ['event.store.client', $event->id], 'autocomplete' => 'off', 'id' => 'event-form','class'=>'form-validate form-horizontal']) !!}
                    <div class="form">
                         <div class="form-group">
                            <label class="control-label col-lg-2">@lang('app.name_participant')</label>
                            <div class="col-lg-6">
                                <input type="text" name="participant" autocomplete="off" class="form-control" value="" placeholder="" id="participant">
                            </div>
                            <div class="col-lg-4">
                              <button class="btn btn-primary" id="add-client" type="submit">
                                @lang('app.add')
                              </button>
                          </div>
                        </div>
                    </div>
                {!! Form::close() !!}

                <br><br>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                  <div class="row">
                   <table class="table table-default">
                     <thead>
                        <tr>
                            <th>@lang('app.full_name')</th>
                            <th class="text-center">@lang('app.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if (count($event->event_clients) > 0)
                              @foreach ($event->event_clients as $client) 
                                  <tr>
                                      <td>{{ $client->participant }}</td>
                                      <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-danger btn-delete" title="@lang('app.delete_participant')"
                                                    data-href="{{ route('event.delete.participant') }}"
                                                    data-id="{{ $client->id }}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-confirm-title="@lang('app.please_confirm')"
                                                    data-confirm-text="@lang('app.are_you_sure_delete_participant')"
                                                    data-confirm-delete="@lang('app.yes_delete_him')">
                                                <i class="icon_close_alt2"></i>
                                            </a>
                                      </td>
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

@section('scripts')
@parent
  <script type="text/javascript">

    $(document).on('click', '#add-client', function (e) { 
       e.preventDefault();
      if($('#participant').val()) {
        var form = $('#event-form');
         $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          dataType: 'json',
          success: function(response) {
              if(response.success){
                window.location.href = response.url_return;
              } else {
                  swal('error', response.message);             
              }         
          },
          error: function (status) {
              console.log(status.statusText);
          }
      });
      } else {
        swal('Debe escribir el nombre del participante');
      }
    });
  </script>
@stop
