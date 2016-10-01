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
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
               <header class="panel-heading">
                   @lang('app.search')
                </header>
                <div class="panel-body">
                    <div class="row">  
                    <form method="GET" action="" accept-charset="UTF-8">  
                        <div class="col-lg-7 col-sm-8 col-xs-12">
                            <div class="input-group">         
                                <input type="text" class="form-control margin_search" name="q" value="{{ Input::get('q') }}" id="search" placeholder="@lang('app.search_song_artist')">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit"><span class="fa fa-search"></span></button>
                                    @if (Input::has('q') && Input::get('q') != '')
                                        <a href="{{ route('song.index') }}" class="btn btn-danger">
                                           <i class="icon_close_alt2"></i>
                                        </a>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </form>
                    </div> 

                    <div class="row">    
                        <div class="col-lg-10 col-sm-10 col-xs-10">
                            <div class="table-responsive">
                               <table class="table">
                                    <thead>
                                    <tr>
                                        <th>@lang('app.song')</th>
                                        <th>@lang('app.artist')</th>
                                        <th>@lang('app.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($songs))
                                        @foreach ($songs as $song) 
                                            <tr>
                                                <td>{{$song->title}}</td>
                                                <td>{{$song->artist}}</td>
                                                <td><a class="btn btn-sm btn-xm btn-success" href="" title="Solicitar">@lang('app.apply_for')</a></td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3"><em>@lang('app.no_records_found')</em></td>
                                    </tr>
                                    @endif                                
                                    </tbody>
                               </table>
                            </div>  
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
$(document).ready(function(e){

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#search').autoComplete({
        minChars: 2,
        source: function(term, response){
            term = term.toLowerCase();
            $.getJSON('{{route("song.search.ajax")}}', 
                { q: term }, 
                function(data){ response(data);
            });
        }
    });
});
</script>

@stop
