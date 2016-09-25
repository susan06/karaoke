@extends('layouts.app')

@section('page-title', trans('app.songs'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.advanced_search')</h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{route('dashboard')}}"> Home</a></li>
                <li><i class="fa fa-play-circle"></i><a href="{{route('song.search')}}"> Canciones</a></li>
                <li><i class="fa fa-search"></i> Búsqueda avanzada</li>
            </ol>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">

            <section class="panel">
                <div class="panel-body">
                    <form class="form-horizontal">
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Artista</label>
                          <div class="col-sm-6">
                              <input type="text" id="artist" class="form-control">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-2 control-label">Canción</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control">
                          </div>
                      </div>
                      <button type="button" class="btn btn-primary">Buscar</button>
                  </form>             
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
                </div>
            </section>

        </div>
    </div>
  <!-- page end-->
@stop

@section('scripts')
<link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css">
<script language="JavaScript" src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>
<script language="JavaScript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script language="JavaScript" src="https://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(e){

    $('#datatable').dataTable({
        "bPaginate": true,
        "bInfo":true
    });

});
</script>

@stop
