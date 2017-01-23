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
                    <div class="row alert-location">
                        <div class="alert alert-block alert-danger fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                          </button>
                          <strong>Lo sentimos.</strong> No es posible votar por un participante, debe estar en la inmediaciones del sitio.
                        </div>  
                    </div>
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
                                        <button type="button" class="btn btn-success register_vote" data-name="{{ $client->participant }}" data-event="{{ $client->event_id }}" data-participant="{{ $client->id }}"> @lang('app.vote') </button>
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
        title: 'Seguro que desea votar por el participante: '+$this.data('name')+'?',   
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

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition,showError);
    } else {
        swal("@lang('app.info')", "La geolocalización no es soportada por el navegador.", "error");
    }
}

function showPosition(position) {
    lat1 = graRad(position.coords.latitude.toFixed(6));
    lng1 = graRad(position.coords.longitude.toFixed(6));

    var lat_site = position.coords.latitude.toFixed(6);
    var lng_site = position.coords.longitude.toFixed(6);
    var radio = 50;

    @if(session('branch_office'))
        var lat_site = {!! session('branch_office')->lat !!};
        var lng_site = {!! session('branch_office')->lng !!};
        var radio = {!! session('branch_office')->radio !!};
    @endif

    var lat2 = graRad(lat_site);
    var lng2 = graRad(lng_site);
    var resta = lng2-lng1;

    var result = Math.acos( Math.sin(lat1)*Math.sin(lat2) + Math.cos(lat1)*Math.cos(lat2) *  Math.cos(resta) );

    var distance = 6371 * result;

    if(distance.toFixed(2) <= radio) {
        $('.register_vote').prop('disabled',false);
        $('.alert-location').hide();
    } else {
        $('.register_vote').prop('disabled',true);
        $('.alert-location').show();
    }
}

function graRad(grados){
        var radianes = (grados * 3.14159265359)/180;
        return radianes; 
}  

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            swal("@lang('app.info')", "Usuario ha denegado la solicitud de geolocalización.", "error");
            break;
        case error.POSITION_UNAVAILABLE:
            swal("@lang('app.info')", "La información de ubicación no está disponible.", "error");
            break;
        case error.TIMEOUT:
            swal("@lang('app.info')", "La solicitud para obtener la ubicación del usuario Tiempo de espera agotado.", "error");
            break;
        case error.UNKNOWN_ERROR:
            swal("@lang('app.info')", "Un error desconocido ocurrió.", "error");
            break;
    }
}

@if(Auth::user()->hasRole('user') && session('branch_office'))
    @if(session('branch_office')->geolocation == 1)
        $('.alert-location').show();
        $('.register_vote').prop('disabled',true);
        getLocation();
    @endif
@endif
</script>
@endsection
