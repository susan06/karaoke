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
                      <strong>Atención!</strong> La primera línea en el archivo csv debe tener el siguiente orden: artist, tilte. No cambiar el orden de las columnas. Los registros deben estar separados por ",".
                  </div>    
                {!! Form::open(['route' => 'song.import.store', 'class' => 'form-validate form-horizontal', 'id' => 'import-form']) !!}
                    <div class="form">
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.file') <span class="required">*</span></label>
                              <div class="col-lg-8 col-sm-8 col-xs-10">
                                 <input type="file" data-browse-label="browse" name="csv_import" class="form-control" id="csv_file" required="required"/>
                              </div>
                          </div>
                         <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                              <button class="btn btn-primary" type="submit">@lang('app.import')</button>
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

{!! JsValidator::formRequest('App\Http\Requests\Song\ImportSongRequest', '#import-form') !!}

@stop
