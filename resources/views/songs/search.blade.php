@extends('layouts.app')

@section('page-title', trans('app.songs'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.ask_song') @if(session('branch_office')) / Sucursal: {{ session('branch_office')->name }} @endif
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
               <header class="panel-heading">
                   @lang('app.search')
                </header>
                <div class="panel-body">
                    <div class="row alert-location">
                        <div class="alert alert-block alert-danger fade in">
                          <button data-dismiss="alert" class="close close-sm" type="button">
                              <i class="icon-remove"></i>
                          </button>
                          <strong>Lo sentimos.</strong> No es posible pedir canciones, debe estar en la inmediaciones del sitio.
                        </div>  
                    </div>

                    <div class="row">    
                        <div class="col-lg-7 col-sm-8 col-xs-12 margin_search">
                            <div class="input-group">         
                                <input type="text" class="form-control" name="q" id="search" placeholder="@lang('app.search_song_artist')">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-search" type="button"><span class="fa fa-search"></span></button>
                                    <button class="btn btn-danger" type="button" id="reset_search"><span class="icon_close_alt2"></span></button>
                                </span>
                            </div>
                        </div>
                  </div> 
                  <div class="row">    
                        <div class="col-lg-10 col-sm-12 col-xs-12">
                            <div id="list_song">
                            <!--<div class="table-responsive">-->
                               <table class="table table-default">
                                    <thead>
                                    <tr>
                                        <th>@lang('app.song')</th>
                                        <th>@lang('app.artist')</th>
                                        <th>@lang('app.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody class="songs" id="result_search">
                                    <tr>
                                        <td colspan="3"><em>@lang('app.first_search')</em></td>
                                    </tr>                            
                                    </tbody>
                               </table>
                            <!--</div>-->  
                            </div>
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

$(document).ready(function(e){

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })

    $('#search').keyup(function(e) {
        var unicode = e.keyCode ? e.keyCode : e.which;    
        if (unicode == 13){ 
            $('#search').autoComplete('destroy'); 
            autocomplete();
            start_search();
        }    
    })

    $('.btn-search').click(function() {
        start_search();
    })

    $('#reset_search').click(function() {
        if ($('#search').val()) { 
            document.getElementById('search').value = '';
            $('#search').autoComplete('destroy'); 
            autocomplete();
            reset_search();
        }
    })

});

    $(document).on('click', '.btn-apply-for', function () {
            var $this = $(this);
            var row = $this.closest('tr');
            swal({   
                title: $this.data('confirm-title'),   
                text: $this.data('confirm-text'),   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: $this.data('confirm'),   
                closeOnConfirm: false }, 
                function(isConfirm){   
                    if (isConfirm) { 
                        swal.close(); 
                        $.ajax({
                            type: 'GET',
                            url: '{{route("song.apply.for")}}',
                            dataType: 'json',
                            data: { 'id': $this.data('id') },
                            success: function (request) { 
                                row.addClass(request.status); 
                                $this.attr('disabled', request.disabled);  
                                swal("@lang('app.info')", request.message, request.status);
                            }
                        }) 
                    }           
                }) 
    });

    $(document).on('click', '.pagination a', function (e) {
        getPages($(this).attr('href'));
        e.preventDefault();
    });

    function getPages(page) {
    if(page) {
        $.ajax({
            url: page,
            type:"GET",
            dataType: 'json',
            success: function(response) {
                $('#list_song').html(response);
            },
            error: function (status) {
                //console.log(status.statusText);
            }
        });
    }
}
    function autocomplete() {
        $('#search').autoComplete({
            minChars: 2,
            source: function(term, response){
                term = term.toLowerCase();
                $.getJSON('{{route("song.search.ajax")}}', 
                    { q: term }, 
                    function(data){ response(data);
                });
            }
        })
    }

    function load_text_search(text) {
        document.getElementById('result_search').innerHTML = '';
        var tr = document.createElement('TR');
        var td = document.createElement('TD');
        var em = document.createElement('em');
        td.setAttribute("colspan", 3);
        var t = document.createTextNode(text);
        em.appendChild(t);
        td.appendChild(em);
        tr.appendChild(td);
        container = document.getElementById('result_search');
        container.appendChild(tr);
        $('#search').focus();
    }

    function reset_search() {
       load_text_search('@lang("app.first_search")');
    }

    function searching() {
       load_text_search('@lang("app.searching")');
    }

    function start_search() {
        if ($('#search').val()) { 
            searching(); 
            $.ajax({
                type: 'get',
                url: '{{route("song.search.ajax.client")}}',
                dataType: 'json',
                data: { 'q': $('#search').val() },
                success: function (response) {                           
                    $('#list_song').html(response);
                },
                error: function () {
                   //
                }
            })     
        } 
    }

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

        //msg += 'mis coordenadas: lat '+position.coords.latitude+' lng '+position.coords.longitude;
        //msg += ' ,coordenadas del sitio: lat '+lat_site+' lng '+lng_site;
        //msg += ' ,radio de medición: '+radio;
        //msg += ' ,distancia del sitio a donde yo estoy: '+distance.toFixed(2);

        if(distance.toFixed(2) <= radio) {
            //msg += ' ,estoy DENTRO del radio de '+radio+' kilometros ';
            $('.btn-search').prop('disabled',false);
            $('.btn-apply-for').prop('disabled', false);
            $('.alert-location').hide();
        } else {
            //msg += ' ,estoy FUERA del radio de '+radio+' kilometros ';
            $('.btn-search').prop('disabled',true);
            $('.btn-apply-for').prop('disabled',true);
            $('.alert-location').show();
        }

        //alert(msg);
     
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
            $('.btn-search').prop('disabled',true);
            $('.btn-apply-for').prop('disabled',true);
            getLocation();
        @endif
    @endif

    autocomplete();

</script>

@stop
