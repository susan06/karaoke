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
                      <div class="row">    
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div class="input-group">         
                                <input type="text" class="form-control" name="q" id="search" placeholder="@lang('app.search_song_artist')">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="fa fa-search"></span></button>
                                </span>
                            </div>
                        </div>
                  </div>                
                </div>
            </section>

            <section class="panel">
                <header class="panel-heading">
                   Resultados de la búsqueda
                </header>
                <div class="panel-body">
                   <table class="table" id="datatable">
                        <thead>
                        <tr>
                            <th>Canción</th>
                            <th>Artista</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Imaginándote</td>
                            <td>Reykon y Daddy Yankee​</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Como yo te quiero</td>
                            <td>El Potro Alvarez y Yandel​</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Me voy enamorando</td>
                            <td>Chino y Nacho</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Báilalo</td>
                            <td>Tomas The Latin Boy</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Baja</td>
                            <td>Guaco</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Vive la vida</td>
                            <td>Sixto Rein con Chino y Nacho</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Me marcharé</td>
                            <td>Los Cadillacs con Wisin</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Única</td>
                            <td>Víctor Drija​</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Siento bonito</td>
                            <td>Juan Miguel</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>
                        <tr>
                            <td>Déjate llevar</td>
                            <td>Jonathan Moly</td>
                            <td><a class="btn btn-success" href="" title="Solicitar">Solicitar</a></td>
                        </tr>                               
                        </tbody>
                   </table>
                    <ul class="pagination">
                    <li class="disabled"><span>&laquo;</span></li> 
                    <li class="active"><span>1</span></li><li><a href="#">2</a></li>
                    <li><a href="#">3</a></li> 
                    <li><a href="#" rel="next">&raquo;</a></li>
                    </ul>
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
    });

    $('#search').autoComplete({
        minChars: 2,
        source: function(term, response){
            term = term.toLowerCase();
            $.getJSON('{{route("song.search.ajax")}}', 
                { q: term }, 
                function(data){ response(data);
            });
        }
    });
});
</script>

@stop
