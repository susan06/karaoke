@extends('emails.layout')

@section('content')

<p>Estado de su reservación # {{ $reservation->num_reservation() }} en {{ Settings::get('app_name') }}</p>
<p>Se ha cambiado el estado de su reserva a:</p>
<p>
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
@else
 <span class="label label-warning"> En proceso... </span>
@endif
<p>Detalles de la reserva:</p>
<p>fecha y hora: {{ date_format(date_create($reservation->date), 'd-m-Y').' '.$reservation->time }}</p>
<p>mesa {{ $reservation->num_table }}</p>
<p>Sucursal {{ $reservation->branchoffice->name }}</p>

@endsection