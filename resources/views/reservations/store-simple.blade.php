@extends('layouts.app')

@section('page-title', trans('app.reservation_table'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_refresh"></i> @lang('app.reservation_table') 
            @if(session('branch_office')) / Sucursal: {{ session('branch_office')->name }} @endif</h3>
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
    <div class="modal fade" tabindex="-1" id="myModalReservation" role="dialog">
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
              <form action="{{route('reservation.client.ajax')}}" method="post" id="form_resersar">
              <input type="hidden" id="table" name="num_table" value=""/>
              <div class="form">
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">@lang('app.date')</label>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <input type="text" name="date" id="datetimepicker1" class="form-control" readonly="readonly" required="required"/>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">
                    @lang('app.hour') 
                    </label>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <input type="text" name="time" id="datetimepicker2" class="form-control" readonly="readonly" required="required" />
                    </div>
                     @if(session('branch_office') && session('branch_office')->reservation_time_min && session('branch_office')->reservation_time_max) 
                        Desde las {{ session('branch_office')->reservation_time_min }} Hasta las {{ session('branch_office')->reservation_time_max }}
                      @endif
                </div>
            </div>
          </div>
          <div class="modal-footer">
          <button type="submit" class="btn btn-success" id="btn-reserved">@lang('app.reserv')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
          </div>
          </form>
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

    var $this = null;
    var user_id = null;

    $('#datetimepicker1').datetimepicker({
      format: 'DD-MM-YYYY',
      minDate: new Date(),
      ignoreReadonly: true
    });

    var hour_min = moment({hour: 19, minute: 00}); 
    var hour_max = moment({hour: 21, minute: 30}); 
    var time_min_text = '7:00 PM';

    @if(session('branch_office') && session('branch_office')->reservation_time_min && session('branch_office')->reservation_time_max) 
      time_min_text = "{{ session('branch_office')->reservation_time_min }}";
      var time_min = moment("{{ session('branch_office')->reservation_time_min }}","h:mm a").format("HH:mm");
      var arr_time_min = time_min.split(':');
      hour_min = moment({hour: parseInt(arr_time_min[0]), minute: parseInt(arr_time_min[1])});
      var time_max = moment("{{ session('branch_office')->reservation_time_max }}","h:mm a").format("HH:mm");
      var arr_time_max = time_max.split(':');
      hour_max = moment({hour: parseInt(arr_time_max[0]), minute: parseInt(arr_time_max[1])});
    @endif      

   $('#datetimepicker2').datetimepicker({
      format: 'LT',
      minDate: hour_min,
      maxDate: hour_max,
      ignoreReadonly: true
   });
 
  $(document).on('click', '.reserv', function () {
    $this = $(this); 
    var table = $this.data("id");
    document.getElementById("datetimepicker1").value = "";
    document.getElementById("datetimepicker2").value = time_min_text;
    document.getElementById("table").value = table;
    $("#num_table").text(table);
    $('#myModalReservation').modal("show");
  });

  function storeFormReservation() {
    $('#modal_login').modal('hide');
    swal({
      title: "Estamos guardando su reserva, esperar por favor",
      imageUrl: "{{ url('/public-img/images/loading-1.gif') }}",
      showConfirmButton: false
    });
    var data_form = {
          'num_table': $("#table").val(), 
          'user_id': user_id,
          'date': $("#datetimepicker1").val(),
          'time': $("#datetimepicker2").val()
        };
    console.log(data_form);

    $.ajax({
        url: "{{route('reservation.simple.client.ajax')}}",
        type: 'post',
        data: data_form,
        dataType: 'json',
        success: function(response) { 
        console.log(response);         
           if(response.success) {  
                $this.prop('disabled', true);                    
                $this.addClass("button-danger");
                $this.removeClass("reserv");
                user_id = null;
                if(response.message_alert) {
                  swal("@lang('app.info')", response.message_alert, "success");
                } else {
                  swal.close();
                }
            } else {
                $this.removeClass("button-danger");
                swal("@lang('app.info')", response.message, "error");
            }
        }
    });
  }

  $(document).on('click', '#btn-reserved', function (e) {
      e.preventDefault();
      if($("#datetimepicker1").val() && $("#datetimepicker2").val() && $("#table").val()) {
          $('#myModalReservation').modal("hide");
          $('#username').val('');
          $('#pin-1').val('');
          $('#pin-2').val('');
          $('#pin-3').val('');
          $('#pin-4').val('');
          $('#pin-2').prop('disabled', true);
          $('#pin-3').prop('disabled', true);
          $('#pin-4').prop('disabled', true);
          $('#modal_login').modal('show');
      } 
  });

  $(document).on('click', '.btn-pin-login', function (e) {
     showLoading();
     var username = $('#username').val();
     var pin = $('#pin-1').val()+$('#pin-2').val()+$('#pin-3').val()+$('#pin-4').val();
     if(username && pin) {
      $.ajax({
          type: 'POST',
          url: '{{route("search-songs.login-pin")}}',
          dataType: 'json',
          data: { 'username': username, 'pin': pin },
          success: function (response) { 
              hideLoading();
              if(response.success) {
                user_id = response.user_id;
                storeFormReservation();
              } else {
                  swal({   
                      title: response.message,     
                      type: response.status,   
                      showCancelButton: false,    
                      confirmButtonText: 'OK'
                  }); 
              }
          },
          error: function (request, status, error) {
              hideLoading(); 
              swal({   
                  title: 'Verifique sus crendeciales si son correctas',     
                  type: 'error',   
                  showCancelButton: false,    
                  confirmButtonText: 'OK'
              }); 
          } 
      }) 
    }
  });
</script>
@stop
