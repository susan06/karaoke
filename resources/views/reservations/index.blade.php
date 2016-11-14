@extends('layouts.app')

@section('page-title', trans('app.reservations'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i>
            @if($admin) 
                @lang('app.reservations')
            @else
                @lang('app.my_reservations')
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
                        <div class="col-lg-4 col-sm-4 col-xs-12 margin_search">
                            <div class='input-group'>
                            @if($all)
                                <input class="form-control" id="date" name="date" value="" readonly="readonly" />
                            @else
                                <input class="form-control" id="date" name="date" value="{{ Input::get('date') ? Input::get('date') : Carbon\Carbon::now()->format('d-m-Y') }}" readonly="readonly" />
                            @endif
                                <a href="{{ route('reservation.index') }}" class="input-group-addon">
                                    @lang('app.today')</a>
                                @if (Auth::user()->hasRole('user'))
                                <a href="{{ route('reservation.index', 'show=all') }}" class="input-group-addon">
                                    @lang('app.all')</a>
                                @endif
                            </div>
                        </div>
                    </form>
                    </div> 

                    <div class="row">    
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                               <table class="table table-default">
                                    <thead>
                                    <tr>
                                        <th>@lang('app.table')</th>
                                        <th>@lang('app.date')</th>
                                        <th>@lang('app.hour')</th>
                                        @if (Auth::user()->hasRole('admin')) 
                                        <th>@lang('app.client')</th>
                                        @endif
                                        <th>@lang('app.status')</th>
                                        <th>@lang('app.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody class="reservations">
                                    @if (count($reservations))
                                        @foreach ($reservations as $reservation) 
                                            <tr>
                                                <td>{{$reservation->num_table}}</td>
                                                <td>{{date_format(date_create($reservation->date), 'd-m-Y')}}</td>
                                                <td>{{$reservation->time}}</td>
                                                @if (Auth::user()->hasRole('admin')) 
                                                <td>
                                                     <a tabindex="0" role="button" 
                                                         data-trigger="focus"
                                                         data-placement="top"
                                                         data-toggle="popover"
                                                         title="Datos del cliente"
                                                         data-content="
                                                         nombre: {{ $reservation->user->first_name . ' ' . $reservation->user->last_name }} <br>
                                                         email: {{ $reservation->user->email }} <br>
                                                         Télefono: {{ $reservation->user->phone }}
                                                          ">
                                                          {{ $reservation->user->first_name . ' ' . $reservation->user->last_name }}
                                                      </a>
                                                </td>
                                                @endif
                                                    <input type="hidden" id="input_status_{{$reservation->id}}" value="{{$reservation->status}}"/>
                                                <td id="status_{{$reservation->id}}">
                                                @if(! $reservation->status == 0)
                                                    @if($reservation->status == 1)
                                                      <span class="label label-success">@lang('app.reserved')</span>
                                                    @endif
                                                    @if($reservation->status == 2)
                                                      <span class="label label-danger">Rechazada</span>
                                                    @endif
                                                @elseif (Auth::user()->hasRole('user'))
                                                    En proceso...
                                                @endif
                                                </td>
                                                
                                                <td>
                                                @if (Auth::user()->hasRole('admin'))
                                                    @if($reservation->status == 1 || $reservation->status == 0)
                                                        <button class="btn btn-lg btn-sm btn-xs btn-warning btn-status"
                                                        data-id="{{$reservation->id}}" title="@lang('app.change_status')" data-toggle="tooltip" data-placement="top"><i class="fa fa-refresh"></i></button>
                                                    @elseif($reservation->status == 2)
                                                        <button class="btn btn-lg btn-sm btn-xs btn-success btn-status"
                                                        data-id="{{$reservation->id}}" title="@lang('app.change_status')" data-toggle="tooltip" data-placement="top"><i class="fa fa-refresh"></i></button>
                                                    @endif  
                                                @endif
                                                 <a href="javascript:void(0)" class="btn btn-sm btn-xs btn-danger btn-delete" title="@lang('app.delete')"
                                                        data-href="{{ route('reservation.delete') }}"
                                                        data-id="{{$reservation->id}}"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        data-confirm-title="@lang('app.please_confirm')"
                                                        data-confirm-text="@lang('app.are_you_sure_delete_reservation')"
                                                        data-confirm-delete="@lang('app.yes_delete_it')">
                                                        <i class="icon_close_alt2"></i>
                                                  </a>
                                                </td>
                                                
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
                            {!! $reservations->render() !!}
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
    format: 'DD-MM-YYYY',
    ignoreReadonly: true
});

 $("#date").on("dp.change", function (e) {
    $("#date-form").submit();
});

$(document).on('click', '.btn-status', function() {
    var $this = $(this);
    var id = $this.data('id');
    var status = $('#input_status_'+id).val();
    if(status == 1 || status == 0) {
        status = 2;
        status_text = '<span class="label label-danger">Rechazada</span>';
    } else if(status == 2) {
        status = 1;
        status_text = '<span class="label label-success">Reservada</span>';
    }
    $.ajax({
        type: 'post',
        url: '{{route("reservation.status.update")}}',
        dataType: 'json',
        data: { 'id': id, 'status': status },
        success: function (request) { 
            if(request.success) {
                $('#input_status_'+id).val(status);
                document.getElementById('status_'+id).innerHTML = status_text;
                if(status == 0 || status == 1 ) {
                    $this.removeClass('btn-success').addClass('btn-warning');
                } else if(status == 2) {
                    $this.removeClass('btn-warning').addClass('btn-success');
                }
            }
        }
    }) 
})
    
</script>

@stop
