@extends('emails.layout')

@section('content')

<p>Estado de la reservación # {{ $reservation->num_reservation() }} </p>
@if($reservation->arrival)
<p>El cliente {{ $client->first_name.' '.$client->last_name }}, ha llegado a su reservación</p>
@else
<p>El cliente {{ $client->first_name.' '.$client->last_name }}, ha cambiado el estado de su reserva a:</p>
@endif
<p style="text-align: center; margin-top: 10px; margin-bottom: 10px;">
@if(! $reservation->status == 0)
  @if($reservation->status == 1)
    <span class="label label-success">@lang('app.reserved')</span>
  @endif
  @if($reservation->status == 2)
    <span class="label label-danger">Rechazada</span>
  @endif
  @if($reservation->status == 3)
    <span class="label label-danger">Cancelada</span>
  @endif
  @if($reservation->arrival)
    <span class="label label-success">Llegada</span>
  @endif
@else
 <span class="label label-warning"> En proceso... </span>
@endif
</p>
<p>Detalles de la reserva:</p>
<p>fecha y hora: {{ date_format(date_create($reservation->date), 'd-m-Y').' '.$reservation->time }}</p>
<p>mesa {{ $reservation->num_table }}</p>
<p>Sucursal {{ $reservation->branchoffice->name }}</p>

@endsection