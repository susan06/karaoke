@extends('layouts.app')

@section('page-title', trans('app.songs'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.ask_song')</h3>
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

    function apply_for() {
        $('.btn-apply-for').click(function() {
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
        })
    }

    function construct_result(songs) {
        document.getElementById('result_search').innerHTML = '';
        $.each(songs.data, function(i, item){
            var tr = document.createElement('TR');

            var td = document.createElement('TD');
            var td1 = document.createElement('TD');
            var td2 = document.createElement('TD');

            var apply_for = document.createTextNode("@lang('app.apply_for')");
            var title = document.createTextNode(item.title);
            var artist = document.createTextNode(item.artist);

            btn = document.createElement('a');
            btn.className = 'btn btn-lg btn-sm btn-xs btn-success btn-apply-for';
            btn.setAttribute("data-id", item.id);
            btn.setAttribute("data-ref", "{{route('song.apply.for', 'id="+item.id+"')}}");
            btn.setAttribute("data-confirm-title", "@lang('app.please_confirm')");
            btn.setAttribute("data-confirm-text", "@lang('app.are_you_sure_apply_song') la canción "+item.title+" de "+item.artist);
            btn.setAttribute("data-confirm", "@lang('app.apply_for')");

            btn.appendChild(apply_for);
            td.appendChild(title);
            td1.appendChild(artist);
            td2.appendChild(btn);
            tr.appendChild(td);
            tr.appendChild(td1);
            tr.appendChild(td2);

            container = document.getElementById('result_search');
            container.appendChild(tr);
        })
        apply_for();
    }

    function start_search() {
        if ($('#search').val()) { 
            searching(); 
            $.ajax({
                type: 'POST',
                url: '{{route("song.search.ajax.client")}}',
                dataType: 'json',
                data: { 'q': $('#search').val() },
                success: function (songs) {                           
                    construct_result(songs);
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

    var lat = 0;
    var lng = 0;
    var lat_site = {{ Settings::get('lat') }};
    var lng_site = {{ Settings::get('lng') }};

    function showPosition(position) {
        lat = position.coords.latitude;
        lng = position.coords.longitude;

        var lat_rd = lat*(Math.PI/180);
        var lat_site_rd = lat_site*(Math.PI/180);

        var distance = (6371 * Math.acos(Math.sin(lat_rd) * Math.sin(lat_site_rd) + Math.cos(Math.sin(lng - lng_site)) * Math.cos(lat_rd) * Math.cos(Math.sin(lat_site)) ));

        if(distance <= 0.05) {
            $('.btn-search').prop('disabled',false);
            $('.btn-apply-for').prop('disabled', false);
        } else {
            $('.btn-search').prop('disabled',true);
            $('.btn-apply-for').prop('disabled',true);
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

    @if(Auth::user()->hasRole('user') && Settings::get('geolocation') == 1)
        $('.alert-location').show();
        $('.btn-search').prop('disabled',true);
        $('.btn-apply-for').prop('disabled',true);
        getLocation();
    @endif

    autocomplete();

</script>

@stop
