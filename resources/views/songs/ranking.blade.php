@extends('layouts.app')

@section('page-title', trans('app.most_requested'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_star"></i> @lang('app.most_requested')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
               <header class="panel-heading">
                  Top 50
                </header>
                <div class="panel-body">
                    <div class="row">  
                    <form method="GET" action="" accept-charset="UTF-8">  
                        <div class="col-lg-7 col-sm-8 col-xs-12 margin_search">
                            <div class="input-group">         
                                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" id="search" placeholder="@lang('app.search_song_artist')">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit"><span class="fa fa-search"></span></button>
                                    @if (Input::has('search') && Input::get('search') != '')
                                        <a href="{{ route('song.my_list') }}" class="btn btn-danger">
                                           <i class="icon_close_alt2"></i>
                                        </a>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </form>
                    </div> 

                    <div class="row">    
                        <div class="col-lg-10 col-sm-10 col-xs-12">
                            <!--<div class="table-responsive">-->
                               <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('app.song')</th>
                                        <th>@lang('app.artist')</th>
                                        @if (Auth::user()->hasRole('user')) 
                                        <th>@lang('app.action')</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody class="ranking">
                                    @if (count($songs))
                                        @foreach ($songs as $playlist) 
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$playlist->song->title}}</td>
                                                <td>{{$playlist->song->artist}}</td>
                                                @if (Auth::user()->hasRole('user')) 
                                                <td>
                                                    <a class="btn btn-lg btn-sm btn-xs btn-success btn-apply-for" 
                                                    data-id="{{$playlist->song_id}}"
                                                    data-count="{{$playlist->count}}"
                                                    data-confirm-title="@lang('app.please_confirm')"
                                                    data-confirm-text="@lang('app.are_you_sure_apply_song') la canción {{$playlist->song->title}} de {{$playlist->song->artist}}"
                                                    data-confirm="@lang('app.apply_for')">
                                                    @lang('app.apply_for')</a>    
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3"><em>@lang('app.no_records_found')</em></td>
                                    </tr>
                                    @endif                                
                                    </tbody>
                               </table>
                            <!--</div>-->  
                            {!! $songs->render() !!}
                        </div>
                    </div> 

                </div>
            </section>

        </div>
    </div>
  <!-- page end-->
@stop

@section('scripts')

<script type="text/javascript">

$(document).on('click', '.btn-apply-for', function() {
    var $this = $(this);
    var row = $this.closest('tr');
    swal({   
        title: $this.data('confirm-title'),   
        text: $this.data('confirm-text'),   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: $this.data('confirm'),   
        closeOnConfirm: false }, 
        function(isConfirm){   
            if (isConfirm) {  
                $.ajax({
                    type: 'GET',
                    url: '{{route("song.apply.for")}}',
                    dataType: 'json',
                    data: { 'id': $this.data('id') },
                    success: function (request) { 
                        row.addClass(request.status); 
                        $this.attr('disabled', request.disabled);  
                        swal("@lang('app.info')", request.message, request.status);
                    }
                }) 
            }           
        }) 
})
    
</script>

@stop
