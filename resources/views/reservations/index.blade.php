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
                        <div class="col-lg-4 col-sm-4 col-xs-8 margin_search">
                            <div class='input-group'>
                                <input class="form-control" id="date" name="date" value="{{ Input::get('date') ? Input::get('date') : Carbon\Carbon::now()->format('d-m-Y') }}" />
                                <a href="{{ route('reservation.index') }}" class="input-group-addon">
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
                                        <th>@lang('app.table')</th>
                                        <th>@lang('app.date')</th>
                                        <th>@lang('app.hour')</th>
                                        @if (Auth::user()->hasRole('admin')) 
                                        <th>@lang('app.client')</th>
                                        <th>@lang('app.status')</th>
                                        <th>@lang('app.action')</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (count($reservations))
                                        @foreach ($reservations as $reservation) 
                                            <tr>
                                                <td>{{$reservation->num_table}}</td>
                                                <td>{{date_format(date_create($reservation->date), 'd-m-Y')}}</td>
                                                <td>{{$reservation->time}}</td>
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
                                                @if (Auth::user()->hasRole('admin')) 
                                                    <input type="hidden" id="input_status_{{$reservation->id}}" value="{{$reservation->status}}"/>
                                                    <td id="status_{{$reservation->id}}">
                                                    @if($reservation->status)
                                                      @lang('app.reserved')
                                                    @endif
                                                    </td>
                                                    <td>
                                                    @if($reservation->status)
                                                        <button class="btn btn-lg btn-sm btn-xs btn-danger btn-status"
                                                        data-id="{{$reservation->id}}" title="@lang('app.change_status')" data-toggle="tooltip" data-placement="top"><i class="fa fa-refresh"></i></button>
                                                    @else
                                                        <button class="btn btn-lg btn-sm btn-xs btn-success btn-status"
                                                        data-id="{{$reservation->id}}" title="@lang('app.change_status')" data-toggle="tooltip" data-placement="top"><i class="fa fa-refresh"></i></button>
                                                    @endif  
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
  format: 'DD-MM-YYYY'
});

 $("#date").on("dp.change", function (e) {
    $("#date-form").submit();
});

$(document).on('click', '.btn-status', function() {
    var $this = $(this);
    var id = $this.data('id');
    var status = $('#input_status_'+id).val();
    if(status == 0) {
        status = 1;
        status_text = 'Reservada';
    } else {
        status = 0;
        status_text = '';
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
                if(status == 0) {
                    $this.removeClass('btn-danger').addClass('btn-success');
                } else {
                    $this.removeClass('btn-success').addClass('btn-danger');
                }
            }
        }
    }) 
})
    
</script>

@stop
