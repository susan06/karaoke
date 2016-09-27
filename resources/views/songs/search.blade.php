@extends('layouts.app')

@section('page-title', trans('app.songs'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.ask_song')</h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{route('dashboard')}}">Home</a></li>
                <li><i class="fa fa-play-circle"></i><a href="{{route('song.search')}}">Canciones</a></li>
                <li><i class="fa fa-search"></i>Búsqueda</li>
            </ol>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">

            <section class="panel">
               <header class="panel-heading">
                   Búsqueda
                </header>
                <div class="panel-body">
                      <div class="row">    
                        <div class="col-xs-8 col-xs-offset-2">
                        <div class="input-group">
                                <div class="input-group-btn search-panel">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                      <span id="search_concept">Filtrar por</span> <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                      <li><a href="#contains">Artista o Canción</a></li>
                                      <li><a href="#contains">Artista</a></li>
                                      <li><a href="#its_equal">Canción</a></li>
                                    </ul>
                                </div>
                                <input type="hidden" name="search_param" value="all" id="search_param">         
                                <input type="text" class="form-control" name="x" placeholder="Búsqueda...">
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

    $('.search-panel .dropdown-menu').find('a').click(function(e) {
    e.preventDefault();
    var param = $(this).attr("href").replace("#","");
    var concept = $(this).text();
    $('.search-panel span#search_concept').text(concept);
    $('.input-group #search_param').val(param);
  });

});
</script>

@stop
