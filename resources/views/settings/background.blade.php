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
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.general_settings')
                </header>
                <div class="panel-body">
                    <ul class="ace-thumbnails">
                      <li>
                        <a href="{{url('upload/login/'.Settings::get('background-login'))}}" title="Photo Title" data-rel="colorbox">
                          <img alt="150x150" height="150" width="150" src="{{url('upload/login/'.Settings::get('background-login'))}}" />
                          <div class="tags">
                            <span class="label label-success">Login</span>
                          </div>
                        </a>

                        <div class="tools">
                          <a href="#" title="Login">
                            <i class="fa fa-check"></i>
                          </a>
                          <a href="#" title="panel">
                            <i class="fa fa-cog"></i>
                          </a>
                        </div>
                      </li>
                      <li>
                        <a href="{{url('upload/login/'.Settings::get('background-admin'))}}" title="Photo Title" data-rel="colorbox">
                          <img alt="150x150" height="150" width="150" src="{{url('upload/login/'.Settings::get('background-admin'))}}" />
                          <div class="tags">
                            <span class="label label-warning">Panel</span>
                          </div>
                        </a>

                        <div class="tools">
                           <a href="#" title="Login">
                            <i class="fa fa-check"></i>
                          </a>
                          <a href="#" title="panel">
                            <i class="fa fa-cog"></i>
                          </a>
                        </div>
                      </li>
                     </ul> 
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

{!! HTML::script('assets/js/jquery.colorbox-min.js') !!}

<script type="text/javascript">
  $(function() {
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
    $("#cboxLoadingGraphic").append("<i class='icon-spinner'></i>");//let's add a custom loading icon

    /**$(window).on('resize.colorbox', function() {
      try {
        //this function has been changed in recent versions of colorbox, so it won't work
        $.fn.colorbox.load();//to redraw the current frame
      } catch(e){}
    });*/
  })
</script>
@stop
