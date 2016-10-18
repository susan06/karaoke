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
                            <td class="text-right"><button class="button-c button-circle reserv" data-id="1">1</button></td>
                            <td class="text-right"><button class="button-c button-circle reserv" data-id="2">2</button></td>
                            <td class="text-right"><button class="button-c button-circle reserv" data-id="3">3</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-right"><button class="button-c button-circle reserv" data-id="5">5</button></td>
                            <td class="text-right"><button class="button-c button-circle reserv" data-id="6">6</button></td>
                            <td class="text-right"><button class="button-c button-circle reserv" data-id="7">7</button></td>
                        </tr>
                        <tr>
                            <td><button class="button-c button-circle reserv" data-id="4">4</button></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><button class="button-c button-circle reserv" data-id="8">8</button></td>
                            <td><button class="button-c button-circle reserv" data-id="9">9</button></td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="barra">B<br>A<br>R<br>R<br>A</td>
                            <td></td>
                            <td><button class="button-c button-circle reserv" data-id="10">10</button></td>
                            <td><button class="button-c button-circle reserv" data-id="11">11</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="button-c button-circle reserv" data-id="12">12</button></td>
                            <td><button class="button-c button-circle reserv" data-id="13">13</button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button class="button-c button-circle reserv" data-id="14">14</button></td>
                            <td><button class="button-c button-circle reserv" data-id="15">15</button></td>
                        </tr>                        
                    </table>
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->

    <!-- /modal -->
    <div class="modal fade" tabindex="-1" id="myModal" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('app.reservation_table'): <span id="num_table"></span></h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-info fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="icon-remove"></i>
                  </button>
                  <strong>Información!</strong> Solo prodrá reservar la mesa si selecciona la fecha y la hora
              </div>
              <div class="form">
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">@lang('app.date')</label>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <input type="text" id="datetimepicker1" class="form-control" readonly="readonly"/>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">@lang('app.hour')</label>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <input type="text" id="datetimepicker2" class="form-control" readonly="readonly" />
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-success" id="reserved">Reservar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@stop

@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('scripts')

{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}

<script type="text/javascript">

  $(function() {

      $('#datetimepicker1').datetimepicker({
        format: 'DD-MM-YYYY',
        minDate: new Date(),
        ignoreReadonly: true
      });

     $('#datetimepicker2').datetimepicker({
        format: 'LT',
        minDate: moment().add(2,'hours'),
        ignoreReadonly: true
     });

    $(".reserv").click(function(){
      var $this = $(this); 
      var table = $this.data("id");
      document.getElementById("datetimepicker1").value = "";
      document.getElementById("datetimepicker2").value = "";
      var data = null;
      $("#num_table").text(table);
      $('#myModal').modal("show");
         $("#reserved").click(function(){
          if($("#datetimepicker1").val() && $("#datetimepicker2").val()) {
            $('#myModal').modal("hide");
            $this.addClass("button-danger");
            data = {"num_table": table, "date": $("#datetimepicker1").val(), "time": $("#datetimepicker2").val()};
                $.ajax({
                  type: "post",
                  url: "{{route('reservation.client.ajax')}}",
                  data: data,
                  dataType: 'json',
                  success: function (data) {  
                    if(data.success) {  
                        $this.prop('disabled', true);                    
                        $this.addClass("button-danger");
                        $this.removeClass("reserv");
                    } else {
                        $(".reserv").removeClass("button-danger");
                        swal("@lang('app.info')", data.message, "error");
                    }
                  }
                })
            }
         });
    });

  })
</script>
@stop
