@extends('emails.layout')

@section('content')

<p>Has obtenido un cupón asociado a tu reservación # 
	{{ $reservation->num_reservation() }} en {{ Settings::get('app_name') }}</p>
<p>Puedes dirigirte a caja para validar el cupón y recibir un descuento</p>

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

<p>Detalles de la reserva:</p>
<p>fecha y hora: {{ date_format(date_create($reservation->date), 'd-m-Y').' '.$reservation->time }}</p>
<p>mesa {{ $reservation->num_table }}</p>
<p>Sucursal {{ $reservation->branchoffice->name }}</p>

@endsection