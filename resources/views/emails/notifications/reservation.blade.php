@extends('emails.layout')

@section('content')

<p>Has recibido una notificación de reservación</p>

<p>Reservación # {{ $reservation->num_reservation() }} </p>

<p>Sucursal: {{ $reservation->branchoffice->name }}</p>

<p>del cliente {{ $client->first_name.' '.$client->last_name }}</p>

<p>para la mesa {{ $reservation->num_table }} </p>

<p>fecha y hora: {{ date_format(date_create($reservation->date), 'd-m-Y').' '.$reservation->time }} </p>

@endsection