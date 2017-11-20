@extends('layouts.app')

@section('page-title', trans('app.new_songs'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_star"></i> @lang('app.new_songs')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
               <header class="panel-heading">
                  Canciones agregadas este mes
                </header>
                <div class="panel-body">
                    <div class="row alert-location">
                        <div class="alert alert-block alert-danger fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                          </button>
                          <strong>Lo sentimos.</strong> No es posible solicitar canciones, debe estar en la inmediaciones del sitio.
                        </div>  
                    </div>

                    <div class="row">    
                        <div class="col-lg-10 col-sm-10 col-xs-12">
                            <!--<div class="table-responsive">-->
                               <table class="table table-default">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('app.song')</th>
                                        <th>@lang('app.artist')</th>
                                        @if (Auth::user()->hasRole('user')) 
                                        <th>@lang('app.action')</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody class="ranking">
                                    @if (count($songs))
                                        @foreach ($songs as $key => $song) 
                                            <tr>
                                                <td>{{ ($songs->currentpage()-1) * $songs->perpage() + $key + 1 }}</td>
                                                <td>{{$song->title}}</td>
                                                <td>{{$song->artist}}</td>
                                                @if (Auth::user()->hasRole('user')) 
                                                <td>
                                                    <a class="btn btn-lg btn-sm btn-xs btn-success btn-apply-for" 
                                                    data-id="{{$song->id}}"
                                                    data-confirm-title="@lang('app.please_confirm')"
                                                    data-confirm-text="@lang('app.are_you_sure_apply_song') la canción {{$song->title}} de {{$song->artist}}"
                                                    data-confirm="@lang('app.apply_for')">
                                                    @lang('app.apply_for')</a>    
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3"><em>@lang('app.no_records_found')</em></td>
                                    </tr>
                                    @endif                                
                                    </tbody>
                               </table>
                            <!--</div>-->  
                            {!! $songs->render() !!}
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

$("#branch_offices").change(function () {
    $("#ranking-form").submit();
});

$(document).on('click', '.btn-apply-for', function() {
    var $this = $(this);
    var row = $this.closest('tr');
    swal({   
        title: $this.data('confirm-title'),   
        text: $this.data('confirm-text'),   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: $this.data('confirm'), 
        cancelButtonText: "Cancelar",    
        closeOnConfirm: false }, 
        function(isConfirm){   
            if (isConfirm) {  
                $.ajax({
                    type: 'GET',
                    url: '{{route("song.apply.for")}}',
                    dataType: 'json',
                    data: { 'id': $this.data('id') },
                    success: function (request) { 
                        row.addClass(request.status); 
                        $this.attr('disabled', request.disabled);  
                        swal({   
                            title: request.message,     
                            type: request.status,   
                            showCancelButton: false,    
                            confirmButtonText: 'OK', 
                            closeOnConfirm: false},
                            function(isConfirm){
                                showLoading();
                                window.location.href = "{{ route('auth.logout') }}";
                        });
                    }
                }) 
            }           
        }) 
})

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition,showError);
    } else {
        swal("@lang('app.info')", "La geolocalización no es soportada por el navegador.", "error");
    }
}

function showPosition(position) {
    lat1 = position.coords.latitude;
    lng1 = position.coords.longitude;

    var lat_site = position.coords.latitude.toFixed(6);
    var lng_site = position.coords.longitude.toFixed(6);
    var radio = 50;

    @if(session('branch_office'))
        var lat_site = {!! session('branch_office')->lat !!};
        var lng_site = {!! session('branch_office')->lng !!};
        var radio = {!! session('branch_office')->radio !!};
    @endif

    var lat2 = lat_site;
    var lng2 = lng_site;

    var result = Math.acos( Math.sin(lat1)*Math.sin(lat2) + Math.cos(lat1)*Math.cos(lat2) *  Math.cos(lng2-lng1) );

    var distance = 6371 * result;

    if(distance <= radio) {
        $('.btn-apply-for').prop('disabled',false);
        $('.alert-location').hide();
    } else {
        $('.btn-apply-for').prop('disabled',true);
        $('.alert-location').show();
    }
 
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
        $('.btn-apply-for').prop('disabled',true);
        getLocation();
    @endif
@endif
    
</script>

@stop
