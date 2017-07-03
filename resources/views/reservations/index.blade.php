@extends('layouts.app')

@section('page-title', trans('app.reservations'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i>
            @if($admin) 
                @lang('app.reservations')
            @else
                @lang('app.my_reservations')  @if(session('branch_office') && Auth::user()->hasRole('user')) / Sucursal: {{ session('branch_office')->name }} @endif
            @endif
            </h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
               <header class="panel-heading">
                  @lang('app.reservations')
                </header>
                <div class="panel-body">
                    <div class="row">  
                    <form method="GET" action="" accept-charset="UTF-8" id="date-form"> 
                        @if($admin && session('branch_offices'))
                          <div class="col-lg-4 col-sm-4 col-xs-5 margin_search">
                              {!! Form::select('branch_office_id', session('branch_offices'), Input::get('branch_office_id'), ['id' => 'branch_offices', 'class' => 'form-control']) !!}
                          </div>
                           <div class="col-lg-2 col-sm-3 col-xs-5 margin_search">
                              <buttom class="btn btn-primary add_reservation">
                                  <i class="fa fa-plus"></i>
                                  @lang('app.add_reservation')
                              </buttom>
                            </div>
                        @endif  
                        <div class="col-lg-4 col-sm-4 col-xs-12 margin_search">
                            <div class='input-group'>
                                <input class="form-control" id="date" name="date" value="{{ Input::get('date') ? Input::get('date') : '' }}" readonly="readonly" />
                                @if($admin)
                                 <a href="{{ route('reservation.adminIndex', 'date='.Carbon\Carbon::now()->format('d-m-Y') ) }}" class="input-group-addon">@lang('app.today')</a>
                                 <a href="{{ route('reservation.adminIndex') }}" class="input-group-addon">
                                    @lang('app.all')</a>
                                @else
                                <a href="{{ route('reservation.index', 'date='.Carbon\Carbon::now()->format('d-m-Y') ) }}" class="input-group-addon">@lang('app.today')</a>
                                <a href="{{ route('reservation.index') }}" class="input-group-addon">
                                    @lang('app.all')</a>
                                @endif
                            </div>
                        </div>
                    </form>
                    </div> 

                    <div id="load-content">
                      @include('reservations.list')
                    </div>

                </div>
            </section>

        </div>
    </div>
  <!-- page end-->

@if($admin)
      <!-- /modal -->
    <div class="modal fade" tabindex="-1" id="myModal" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">@lang('app.reservation')</h4>
          </div>
          <div class="modal-body">
              <div class="alert alert-danger fade in" id="validate-reservation">
                <button data-dismiss="alert" class="close close-sm" type="button">
                      <i class="icon-remove"></i>
                  </button>
                  <strong>Advertencia!</strong> Todos los campos son obligatorios
              </div>
              <form action="{{route('reservation.admin.ajax')}}" method="post" id="form_resersar">
              <div class="form">
                 <div class="row form-group">
                      <label class="control-label col-lg-2 col-xs-3">Nombre*</label>
                      <div class="col-lg-6 col-sm-6 col-xs-12">
                        <input type="text" name="name_client" id="name_client" class="form-control" required="required"/>
                      </div>
                  </div>
                  <div class="row form-group">
                      <label class="control-label col-lg-2 col-xs-3">Apellido*</label>
                      <div class="col-lg-6 col-sm-6 col-xs-12">
                        <input type="text" name="last_client" id="last_client" class="form-control" required="required"/>
                      </div>
                  </div>
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">Email*</label>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                      <input type="text" name="email_client" id="email_client" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">Télefono*</label>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                      <input type="text" name="phone_client" id="phone_client" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">@lang('app.branch_office')*</label>
                    <div class="col-lg-6 col-sm-6 col-xs-12">
                      {!! Form::select('branch_office_id', session('branch_offices'), '', ['id' => 'branch_offices_reservation', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">@lang('app.table')*</label>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <input type="text" name="num_table" id="table" class="form-control" required="required"/>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">@lang('app.date')*</label>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <input type="text" name="date" id="datetimepicker1" class="form-control" readonly="readonly" required="required"/>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="control-label col-lg-2 col-xs-3">
                    @lang('app.hour')* 
                    </label>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <input type="text" name="time" id="datetimepicker2" class="form-control" readonly="readonly" required="required" />
                    </div>
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
@endif

@if(Auth::user()->hasRole('user'))
<div class="modal fade" tabindex="-1" id="uploadGroupfie" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Subir foto GROUPFIE</h4>
          </div>
          <div class="modal-body">
              <form action="{{route('reservation.upload.groupfie')}}" method="post" enctype="multipart/form-data" id="form_upload_groupfie">
              <div class="form">
                 <div class="row form-group">
                      <label class="control-label col-lg-2 col-xs-12">Imagen*</label>
                      <div class="col-lg-610 col-sm-10 col-xs-12">
                        <input type="file" name="groupfie" id="groupfie" class="form-control" value=""/>
                        <input type="hidden" id="groupfie_reservation" name="">
                      </div>
                  </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="btn-submit-modal-file">@lang('app.save')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('app.close')</button>
          </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
</div>
@endif

@stop

@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('scripts')

{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}

<script type="text/javascript">

@if($admin)
  $('#datetimepicker1').datetimepicker({
    format: 'DD-MM-YYYY',
    minDate: new Date(),
    ignoreReadonly: true
  });

 $('#datetimepicker2').datetimepicker({
    format: 'LT',
    ignoreReadonly: true
 });

$(document).on('click', '.add_reservation', function () {
  $this = $(this); 
  var table = $this.data("id");
  document.getElementById("datetimepicker1").value = "";
  document.getElementById("datetimepicker2").value = "";
  document.getElementById("table").value = "";
  document.getElementById("branch_offices_reservation").value = "";
  $('#validate-reservation').hide();
  $('#myModal').modal("show");
});

$(document).on('click', '#btn-reserved', function (e) {
    e.preventDefault();
    if($("#datetimepicker1").val() && 
      $("#datetimepicker2").val() && 
      $("#table").val() &&
      $("#email_client").val() &&
      $("#name_client").val() &&
      $("#last_client").val() &&
      $("#phone_client").val()
    ) {
      $('#btn-reserved').text('Guardando...');
      $.ajax({
          url: "{{route('reservation.admin.ajax')}}",
          type: 'post',
          data: $('#form_resersar').serialize(),
          dataType: 'json',
          success: function(response) {
              $('#btn-reserved').text("@lang('app.reserv')");
              if(response.success) {  
                getPages(CURRENT_URL);
                $('#myModal').modal("hide");
              } else {
                swal("@lang('app.info')", response.message, "error");
              }
          }
      });
    } else {
      $('#btn-reserved').text("@lang('app.reserv')");
      $('#validate-reservation').show();
    }
});
@endif

$("#branch_offices").change(function () {
    $("#date-form").submit();
});

$('#date').datetimepicker({
    format: 'DD-MM-YYYY',
    ignoreReadonly: true
});

 $("#date").on("dp.change", function (e) {
    $("#date-form").submit();
});

$(document).on('click', '.btn-status', function() {
    var $this = $(this);
    var id = $this.data('id');
    var next_status = $('#input_status_'+id).val();
    var status = 0;
    if(next_status == 1) {
        status = next_status;
        next_status = 2;
        status_text = '<span class="label label-success">Reservada</span>';      
    } else if(next_status == 2) {
        status = next_status;
        next_status = 1;
        status_text = '<span class="label label-danger">Rechazada</span>';
    } 
    $.ajax({
        type: 'post',
        url: '{{route("reservation.status.update")}}',
        dataType: 'json',
        data: { 'id': id, 'status': status },
        success: function (request) { 
            if(request.success) {              
                $('#input_status_'+id).val(next_status);
                document.getElementById('status_'+id).innerHTML = status_text;
                if(status == 0 || status == 1 ) {
                    $this.removeClass('btn-success').removeClass('btn-warning').addClass('btn-warning');
                    $this.text('Rechazar Reserva');
                } else if(status == 2) {
                    $this.removeClass('btn-danger').removeClass('btn-warning').addClass('btn-success');
                    $this.text('Aprobar Reserva');
                }
            }
        }
    }) 
})
 
$(document).on('click', '.btn-status-cancel', function() {
    var $this = $(this);
    swal({   
      title: "@lang('app.please_confirm')",   
      text: "Seguro que desea cancelar la reserva #"+$this.data('num'),   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si quiero",  
      cancelButtonText: "Cancelar",   
      closeOnConfirm: false }, 
      function(isConfirm){   
          if (isConfirm) {  
              var id = $this.data('id');
              var old_status = $this.data('status');
              var change = $this.data('change');
              if(old_status == 1) {
                old_status_text = '<span class="label label-success">Reservada</span>';
              } else if(old_status == 2) {
                old_status_text = '<span class="label label-danger">Rechazada</span>';
              } 
              var status = 3;
              var status_text = '<span class="label label-danger">Cancelada</span>';
              $.ajax({
                  type: 'post',
                  url: '{{route("reservation.status.update")}}',
                  dataType: 'json',
                  data: { 'id': id, 'status': status },
                  success: function (request) { 
                      if(request.success) {
                          $('#input_status_'+id).val(status);
                          document.getElementById('status_'+id).innerHTML = status_text;
                          $this.hide();
                          swal.close();
                      }
                  }
              })                              
          } 
      });
})   

$(document).on('click', '.btn-arrival', function() {
    var $this = $(this); 
    var id = $this.data('id');
    $.ajax({
        type: 'post',
        url: '{{route("reservation.arrival.update")}}',
        dataType: 'json',
        data: { 'id': id },
        success: function (request) { 
            if(request.success) {
               document.getElementById('status_'+id).innerHTML += '<span class="label label-success">Llegada</span>';
               $('#cancel-'+id).hide();
               $('#upload-group-'+id).show();
               $('#upload-group-'+id).removeClass('hide').addClass('show');
               $this.hide();
            }
        }
    })                              
}); 

$(document).on('click', '.btn-upload-group', function() {
    var $this = $(this);
    var reservation = $this.data('id');
    $('#groupfie').val('');
    $('#groupfie_reservation').val(reservation);
    $('#btn-submit-modal-file').text('Guardar');
    $('#uploadGroupfie').modal("show");
});

$(document).on('click', '#btn-submit-modal-file', function (e) {
    e.preventDefault();
    var $this = $(this);
    if($('#groupfie').val()) {
      $('#btn-submit-modal-file').text('Guardando...');
      swal({
        title: "Subiendo imagen, por favor no salir hasta terminar el proceso",
        imageUrl: "{{ url('/public-img/images/loading-1.gif') }}",
        showConfirmButton: false
      });
      var reservation_id = $('#groupfie_reservation').val();
      var form = $('#form_upload_groupfie'); 
      var formData = new FormData();
      formData.append('groupfie', $('input[type=file]')[0].files[0]); 
      formData.append('id', reservation_id);
      $.ajax({
          url: form.attr('action'),
          type: 'POST',
          data:  formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
              $('#btn-submit-modal-file').text('Guardar');
              if(response.success){
                $('#show-groupfie-'+reservation_id).show();
                  $('#uploadGroupfie').modal('hide');                  
                  swal({
                    title: 'Importante...!',
                    text: response.message,
                    html: true,
                    showConfirmButton: true,
                    allowOutsideClick: true
                  });
                  $('#upload-group-'+reservation_id).removeClass('show').addClass('hide');
                  $('#show-groupfie-'+reservation_id).removeClass('hide').addClass('show');
                   $.ajax({
                        type: 'post',
                        url: '{{route("reservation.send.groupfie")}}',
                        data: { 'id': reservation_id },
                        success: function (request) { 
                            //
                        }
                    })     
             } else {
                if(response.validator) {
                  var message = '';
                  $.each(response.message, function(key, value) {
                    message += value+' ';
                  });
                  sweetAlert("Oops...", message, "error");
                } else {
                  sweetAlert("Oops...", response.message, "error");
                }
              } 
          },
          error: function (status) {
              console.log(status.statusText);
          }
      });
    }
});

$(document).on('click', '.coupon-aplique', function (e) {
   e.preventDefault();
   var $this = $(this);
   var id = $this.data('id');
   swal({   
    title: "@lang('app.please_confirm')",   
    text: "Seguro que desea usar el cupón de la reservación #"+$this.data('num'),   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Si aplicar descuento",  
    cancelButtonText: "Cancelar",   
    closeOnConfirm: false }, 
    function(isConfirm){   
        if (isConfirm) {     
          $.ajax({
            type: 'post',
            url: '{{route("reservation.update.status.coupon")}}',
            dataType: 'json',
            data: { 'id': id, 'reservation': $this.data('num') },
              dataType: 'json',
              success: function(response) {
                  if(response.success){
                      $('#general-modal').modal('hide');                  
                      swal({
                        title: 'Importante...!',
                        text: response.message,
                        html: true,
                        showConfirmButton: true,
                        allowOutsideClick: true
                      });   
                 } else {
                     console.log(response);
                  } 
              },
              error: function (status) {
                  console.log(status.statusText);
              }
          });
        }
    })
});
</script>

@stop
