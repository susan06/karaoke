@extends('layouts.app')

@section('page-title', trans('app.reservation_table'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_refresh"></i> @lang('app.reservation_table')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-5 col-md-6 col-xs-10">
            <section class="panel">
                <div class="panel-body">
                    <table class="table-resevations" width="100%">
                        <tr>
                            <td><button class="button-circle btn-t">TARIMA</button></td>
                            <td class="text-right"><button class="button-c button-circle">1</button></td>
                            <td class="text-right"><button class="button-c button-circle">2</button></td>
                            <td class="text-right"><button class="button-c button-circle">3</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-right"><button class="button-c button-circle">5</button></td>
                            <td class="text-right"><button class="button-c button-circle">6</button></td>
                            <td class="text-right"><button class="button-c button-circle">7</button></td>
                        </tr>
                        <tr>
                            <td><button class="button-c button-circle">4</button></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><button class="button-c button-circle">8</button></td>
                            <td><button class="button-c button-circle">9</button></td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="barra">B<br>A<br>R<br>R<br>A</td>
                            <td></td>
                            <td><button class="button-c button-circle">10</button></td>
                            <td><button class="button-c button-circle">11</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="button-c button-circle">12</button></td>
                            <td><button class="button-c button-circle">13</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="button-c button-circle">14</button></td>
                            <td><button class="button-c button-circle">15</button></td>
                        </tr>                        
                    </table>
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->
@stop
