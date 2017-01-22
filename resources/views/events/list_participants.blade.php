@extends('layouts.app')

@section('page-title', trans('app.contests'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_genius"></i> 
                {{  trans('app.contest').': '.$event->name }}
            </h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.participants')
                </header>
                <div class="panel-body">

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
                                      <td>
                                      {{ $client->participant }}
                                      </td>
                                      <td class="text-center">
                                        <button type="button" class="btn btn-success register_vote" data-event="{{ $client->event_id }}" data-participant="{{ $client->id }}"> @lang('app.vote') </button>
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
                  </div>
                </div>
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->
@stop

@section('scripts')
<script type="text/javascript">
  $(document).on('click', '.register_vote', function () {
    var $this = $(this);
    swal({   
        title: 'Seguro que desea votar por el participante seleccionado?',   
        text: 'Solo podrá votar una vez por concurso',   
        type: "warning",   
        showCancelButton: true,   
        cancelButtonText: 'Cancelar',
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: 'Si, Votar',   
        closeOnConfirm: true },
        function(isConfirm){   
            if (isConfirm) {
                $.ajax({
                    type: 'get',
                    url: "{{ route('event.vote.participants') }}",
                    dataType: 'json',
                    data: { 
                      'event_id': $this.data('event'), 
                      'event_client_id': $this.data('participant') 
                    },
                    success: function (response) { 
                        if(response.success){
                          swal(response.message);   
                        } else {
                          swal('Error', response.message);             
                        }   
                    },
                    error: function (status) {
                        console.log(status.statusText);
                    }
                });     
        } 
    });
});
</script>
@endsection
