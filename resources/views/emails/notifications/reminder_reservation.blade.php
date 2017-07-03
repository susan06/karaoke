@extends('emails.layout')

@section('content')

<p>Recordatorio de su reservación # {{ $reservation->num_reservation() }} </p>
<p>Le estamos recordando que tiene una reserva para hoy.</p>
<p>Detalles de la reservación:</p>
<p>Fecha y hora: {{ date_format(date_create($reservation->date), 'd-m-Y').' '.$reservation->time }}</p>
<p>Mesa {{ $reservation->num_table }}</p>
<p>Sucursal {{ $reservation->branchoffice->name }}</p>

@endsection