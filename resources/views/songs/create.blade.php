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
                   @lang('app.create_song')
                </header>
                <div class="panel-body">
                {!! Form::open(['route' => 'song.store', 'class' => 'form-validate form-horizontal', 'id' => 'song-form']) !!}
                    <div class="form">
                          <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.artist') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('artist',old('artist'), ['id' => 'artist', 'class' => 'form-control', 'placeholder' => trans('app.artist')]) !!}
                              </div>
                          </div>
                         <div class="form-group">
                              <label for="cname" class="control-label col-lg-2">@lang('app.title') <span class="required">*</span></label>
                              <div class="col-lg-6">
                                  {!! Form::text('title',old('title'), ['class' => 'form-control', 'placeholder' => trans('app.title')]) !!}
                              </div>
                          </div>
                         <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                              <button class="btn btn-primary" type="submit">@lang('app.add')</button>
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

{!! HTML::script('assets/js/jquery.js') !!}
{!! HTML::script('assets/js/jquery.validate.min.js') !!}

@section('scripts')

<script type="text/javascript">
$(document).ready(function(e){

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#artist').autoComplete({
        minChars: 2,
        source: function(term, response){
            term = term.toLowerCase();
            $.getJSON('{{route("song.artist.search.ajax")}}', 
                { artist: term }, 
                function(data){ response(data);
            });
        }
    });

    $("#song-form").validate({
            rules: {
                title: {
                    required: true
                },
                artist: {
                    required: true
                },
            },
            messages: {                
                title: {
                    required: "Campo obligatorio",
                },
                artist: {
                    required: "Campo obligatorio",
                }   
            }
    });
});
</script>

@stop
