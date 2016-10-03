@extends('layouts.app')

@section('page-title', trans('app.most_requested'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.requested_songs')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
               <header class="panel-heading">
                  @lang('app.requested_songs')
                </header>
                <div class="panel-body">
                    <div class="row">  
                    <form method="GET" action="" accept-charset="UTF-8" id="date-form">  
                        <div class="col-lg-4 col-sm-4 col-xs-8">
                            <div class='input-group'>
                                <input class="form-control" id="date" name="date" value="{{ Input::get('date') ? Input::get('date') : Carbon\Carbon::now()->format('d-m-Y') }}" />
                                <a href="{{ route('song.apply.list') }}" class="input-group-addon">
                                    Hoy</a>
                            </div>
                        </div>
                    </form>
                    </div> 

                    <div class="row">    
                        <div class="col-lg-10 col-sm-10 col-xs-12">
                            <div class="table-responsive">
                               <table class="table">
                                    <thead>
                                    <tr>
                                        <th>@lang('app.song')</th>
                                        <th>@lang('app.artist')</th>
                                        @if (Auth::user()->hasRole('dj')) 
                                        <th>@lang('app.action')</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($songs))
                                        @foreach ($songs as $playlist) 
                                            <tr>
                                                <td>{{$playlist->song->title}}</td>
                                                <td>{{$playlist->song->artist}}</td>
                                                @if (Auth::user()->hasRole('dj')) 
                                                <td>
                                                    <a class="btn btn-xs btn-success btn-apply-for" 
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

@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('scripts')

{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}

<script type="text/javascript">

$('#date').datetimepicker({
  format: 'DD-MM-YYYY'
});

 $("#date").on("dp.change", function (e) {
    $("#date-form").submit();
});

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
