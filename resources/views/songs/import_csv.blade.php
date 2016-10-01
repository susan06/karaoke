@extends('layouts.app')

@section('page-title', trans('app.songs'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.songs')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.import_songs')
                </header>
                <div class="panel-body">
                  <div class="alert alert-info fade in">
                      <button data-dismiss="alert" class="close close-sm" type="button">
                          <i class="icon-remove"></i>
                      </button>
                      <strong>Atención!</strong> La primera línea en el archivo csv indica las columnas, el nombre correspondiente es: artist, title. Los registros deben estar separados por ",".
                  </div>    
                {!! Form::open(['route' => 'song.import.store', 'files'=>'true', 'class' => 'form-validate form-horizontal', 'id' => 'import-form']) !!}
                    <div class="form">
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2 col-sm-2 col-xs-2">@lang('app.file') <span class="required">*</span></label>
                              <div class="col-lg-8 col-sm-8 col-xs-10">
                                 <input type="file" name="csv_import" class="form-control"/>
                              </div>
                          </div>
                         <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                              <input class="btn btn-primary" type="submit" id="btn-submit" value="@lang('app.import')"/>
                          </div>
                        </div>
                    </div>
                 {!! Form::close() !!}
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->
@stop


@section('scripts')

{!! HTML::script('assets/js/jquery.validate.min.js') !!}

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    
  $("#import-form").validate({
      rules: {
          csv_import: {
              required: true,
              extension: "csv"
          }
      },
      messages: {                
          csv_import: {
              required: "Campo obligatorio",
              extension: "El archivo debe ser de tipo csv"
          } 
      },
      submitHandler: function (form) {
        document.getElementById("btn-submit").value = "Subiendo...";
        document.getElementById("btn-submit").disabled = true; 
        form.submit();
      },
  });
})
</script>
@stop
