@extends('layouts.app')

@section('page-title', trans('app.most_requested'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.requested_songs')
            </h3>
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
                        @if(session('branch_offices'))
                          <div class="col-lg-4 col-sm-4 col-xs-5 margin_search">
                              {!! Form::select('branch_office_id', session('branch_offices'), Input::get('branch_office_id'), ['id' => 'branch_offices', 'class' => 'form-control']) !!}
                          </div>
                        @endif  
                        <div class="col-lg-4 col-sm-4 col-xs-8 margin_search">
                            <div class='input-group'>
                                <input class="form-control" id="date" name="date" value="{{ Input::get('date') ? Input::get('date') : Carbon\Carbon::now()->format('d-m-Y') }}" />
                                <a href="{{ route('song.apply.list') }}" class="input-group-addon">
                                    @lang('app.today')</a>
                            </div>
                        </div>
                    </form>
                    </div> 

                    <div class="row">    
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                               <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Sucursal</th>
                                        <th>@lang('app.song')</th>
                                        <th>@lang('app.artist')</th>
                                        @if (Auth::user()->hasRole('dj')) 
                                        <th>@lang('app.hour')</th>
                                        <th>@lang('app.who_apply')</th>
                                        <th>@lang('app.status')</th>
                                        <th>@lang('app.action')</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($songs))
                                        @foreach ($songs as $playlist) 
                                            <tr class="@if($playlist->play_status) success @endif">
                                                <td>
                                                   {{$playlist->branchoffice->name}} 
                                                </td>
                                                <td>{{$playlist->song->title}}</td>
                                                <td>{{$playlist->song->artist}}</td>
                                                @if (Auth::user()->hasRole('dj')) 
                                                <td>{{ date_format(date_create($playlist->created_at), 'h:m A') }}</td>
                                                <td>
                                                    @if($playlist->user_id)
                                                    {{$playlist->user->present()->nameOrEmail}}
                                                    @else
                                                    {{$playlist->nick}}
                                                    @endif
                                                </td>
                                                <td id="status_{{$playlist->id}}">
                                                @if($playlist->play_status)
                                                  <strong>@lang('app.placed')</strong>
                                                @else
                                                   @lang('app.place')
                                                @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-lg btn-sm btn-xs btn-success btn-apply-for"
                                                    title="@lang('app.play')" 
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    data-id="{{$playlist->id}}"
                                                    data-confirm-title="@lang('app.please_confirm')"
                                                    data-confirm-text="@lang('app.are_you_sure_apply_song') la canción {{$playlist->song->title}} de {{$playlist->song->artist}}"
                                                    data-confirm="@lang('app.play')">
                                                    <i class="fa fa-play-circle"></i></a>    
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

$("#branch_offices").change(function () {
    $("#date-form").submit();
});

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
        cancelButtonText: "Cancelar",    
        closeOnConfirm: false }, 
        function(isConfirm){   
            if (isConfirm) { 
                swal.close(); 
                $.ajax({
                    type: 'GET',
                    url: '{{route("song.dj.play")}}',
                    dataType: 'json',
                    data: { 'id': $this.data('id') },
                    success: function (request) { 
                        row.addClass(request.status); 
                        if(request.success) {
                            document.getElementById('status_'+$this.data('id')).innerHTML = "<strong>@lang('app.placed')</strong>";
                        }
                    }
                }) 
            }           
        }) 
})
    
</script>

@stop
