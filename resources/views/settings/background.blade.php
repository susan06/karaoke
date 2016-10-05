@extends('layouts.app')

@section('page-title', trans('app.settings'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_cog"></i> @lang('app.background')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.general_settings')
                </header>
                <div class="panel-body">
                    {!! Form::open(['route' => 'image.upload', 'files'=>'true', 'class' => 'form-validate form-horizontal', 'id' => 'upload-form']) !!}
                    <div class="form">
                          <div class="form-group margin_search">
                              <div class="col-lg-5 col-sm-6 col-xs-8">
                                 <input type="file" name="image" class="form-control"/>
                              </div>
                              <div class="col-lg-2 col-sm-2 col-xs-2">
                                <input class="btn btn-primary" type="submit" id="btn-submit" value="@lang('app.upload')"/>
                              </div>
                          </div>
                    </div>
                 {!! Form::close() !!}
                 
                  <div class="row margin-top"> 
                    <div class="col-lg-12 col-md-12 col-xs-12">
                      <ul class="ace-thumbnails">
                        @foreach(Storage::disk('login')->files() as $image)
                          <?php
                            $image_array = explode('.', $image);
                            $img = $image_array[0];
                            $ext = $image_array[1];
                          ?>
                            <li>
                              <a href="{{url('upload/login/'.$image)}}" title="Photo Title" data-rel="colorbox">
                                <img alt="150x150" height="150" width="150" src="{{url('upload/login/'.$image)}}" />
                                <div class="tags" id="tag_{{$img}}">
                                    @if(Settings::get('background-admin') == $image )
                                      <span class="label label-warning tag_admin">Panel</span>
                                    @endif
                                    @if(Settings::get('background-login') == $image )
                                      <span class="label label-success tag_login">Login</span>
                                    @endif
                                </div>
                              </a>

                              <div class="tools">
                                 <span href="#" class="label label-success check" data-id="{{$image}}" data-name="{{$img}}" data-type="background-login">
                                  Login
                                </span>
                                <span href="#" class="label label-warning check" data-id="{{$image}}" data-name="{{$img}}" data-type="background-admin">
                                  Panel
                                </span>
                              </div>
                            </li>
                        @endforeach
                       </ul> 
                    </div>
                  </div>
                </div>

            </section>
        </div>
    </div>
  <!-- page end-->
@stop

@section('styles')
  {!! HTML::style("assets/css/colorbox.css") !!}
@stop
        <!--page specific plugin scripts-->
@section('scripts')

{!! HTML::script('assets/js/jquery.validate.min.js') !!}

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

{!! HTML::script('assets/js/jquery.colorbox-min.js') !!}

<script type="text/javascript">

  var image_login = "{{Settings::get('background-login')}}";
  var image_admin = "{{Settings::get('background-admin')}}";

  $(function() {

    $("#upload-form").validate({
        rules: {
            image: {
                required: true,
                extension: "png|jpg|jpeg"
            }
        },
        messages: {                
            image: {
                required: "Campo obligatorio",
                extension: "El archivo debe ser de tipo png|jpg|jpeg"
            } 
        },
        submitHandler: function (form) {
          document.getElementById("btn-submit").value = "Subiendo...";
          document.getElementById("btn-submit").disabled = true; 
          form.submit();
        },
    });

    $(".check").click(function(){
      var $this = $(this); 
      var key = $this.data("type");
      var image = $this.data("id"); 
      var name = $this.data("name");
      if(key == "background-admin") {
        var data = {"background-admin": $this.data("id")};
      } else {
        var data = {"background-login": $this.data("id")};
      }
      $.ajax({
          type: "post",
          url: "{{route('settings.update.ajax')}}",
          data: data,
          success: function (data) {                         
              if(data.success) {
                if(key == "background-admin") {
                  $(".tag_admin").hide();
                  $("#tag_" + name).html('<span class="label label-warning tag_admin">Panel</span>'); 
                  image_admin = image;
                } else {
                  $(".tag_login").hide();
                  $("#tag_" + name).html('<span class="label label-success tag_login">Login</span>');
                  image_login = image;
                }
              }
          }
      })
    });

    var colorbox_params = {
      reposition:true,
      scalePhotos:true,
      scrolling:false,
      previous:'<i class="icon-arrow-left"></i>',
      next:'<i class="icon-arrow-right"></i>',
      close:'&times;',
      current:'{current} of {total}',
      maxWidth:'100%',
      maxHeight:'100%',
      onOpen:function(){
        document.body.style.overflow = 'hidden';
      },
      onClosed:function(){
        document.body.style.overflow = 'auto';
      },
      onComplete:function(){
        $.colorbox.resize();
      }
    };

    $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
    $("#cboxLoadingGraphic").append("<i class='icon-spinner'></i>");

  })
</script>
@stop
