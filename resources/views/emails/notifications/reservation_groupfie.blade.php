@extends('emails.layout')

@section('content')

<p>Has recibido una notificación de GROUPFIE</p>

<p>Reservación # {{ $reservation->num_reservation() }} </p>

<p>Sucursal: {{ $reservation->branchoffice->name }}</p>

<p>del cliente {{ $client->first_name.' '.$client->last_name }}</p>

<p>para la mesa {{ $reservation->num_table }} </p>

<p>fecha y hora: {{ date_format(date_create($reservation->date), 'd-m-Y').' '.$reservation->time }} </p>

<p>Foto subida</p>

<div style="text-align: center;">
	<img height="150" width="150" src="{{ $message->embed(public_path().'/upload/groupfie/'.$reservation->groupfie) }}">
</div>

<p>Cupón generado</p>

 <div class="coupons">
	<div class="coupons-inner">
	{{ trans('app.content_coupon', ['percentage' => $reservation->coupon->percentage]) }}
	  <div class="coupons-code {{ $reservation->coupon->validity_class() }}">
	  {{ $reservation->coupon->codeDecrypt() }}
	  </div>
	  <div class="one-time">
	  @if($reservation->coupon->status == 'Valid')
	    @lang('app.validity'): {{ $reservation->coupon->validity }}
	  @else
	    @if($reservation->coupon->status == 'noValid')
	      @lang('app.novalidity_admin')
	    @elseif($reservation->coupon->status == 'Used')
	      @lang('app.novalidity_client')
	    @endif
	  @endif
	  </div>
	</div>
</div>

@endsection