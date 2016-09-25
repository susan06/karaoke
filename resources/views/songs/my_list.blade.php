@extends('layouts.app')

@section('page-title', trans('app.songs'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.my_list')</h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="{{route('dashboard')}}">Home</a></li>
                <li><i class="fa fa-play-circle"></i><a href="{{route('song.my_list')}}">Canciones</a></li>
                <li><i class="fa fa-bars"></i>@lang('app.my_list')</li>
            </ol>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">

            <section class="panel">
                <header class="panel-heading">
                   Mis canciones solicitas
                </header>
                <div class="panel-body">
                   <table class="table" id="datatable">
                        <thead>
                        <tr>
                            <th>Canción</th>
                            <th>Artista</th>
                            <th># num Solicitada</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Imaginándote</td>
                            <td>Reykon y Daddy Yankee​</td>
                            <td>5</td>
                        </tr>
                        <tr>
                            <td>Como yo te quiero</td>
                            <td>El Potro Alvarez y Yandel​</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Me voy enamorando</td>
                            <td>Chino y Nacho</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <td>Báilalo</td>
                            <td>Tomas The Latin Boy</td>
                            <td>1</td>
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