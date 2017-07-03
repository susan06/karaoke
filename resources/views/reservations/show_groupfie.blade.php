<div class="modal-body">

	<p>Mesa {{ $reservation->num_table }}. Fecha y hora: {{ date_format(date_create($reservation->date), 'd-m-Y').' '.$reservation->time }}. Sucursal: {{ $reservation->branchoffice->name }}.
	@if(!Auth::user()->hasRole('user'))
	Cliente {{ $reservation->user->first_name.' '.$reservation->user->last_name }}.
	@endif
	</p>

	<div style="text-align: center;">
		<p>Foto subida</p>
		<img height="180" width="150" src="{{ url('upload-img/groupfie/'.$reservation->groupfie) }}">
	</div>

	<p style="text-align: center;">
		@if($reservation->coupon->status == 'Valid' && (date('d-m-Y') > $reservation->coupon->validity))
			11<br><span class="label label-danger">Cupón ya no es válido, fecha vencida</span>
		@elseif($reservation->coupon->status == 'Used')
		    <br><span class="label label-warning">Cupón ya usado</span>
		@endif
	</p>

	 <div class="coupons">
		<div class="coupons-inner">
		{{ trans('app.content_coupon', ['percentage' => $reservation->coupon->percentage]) }}
		  <div class="coupons-code {{ $reservation->coupon->validity_class() }}">
		  {{ $reservation->coupon->codeDecrypt() }}
		  </div>
		  <div class="one-time">
		  	@lang('app.validity'): {{ $reservation->coupon->validity }}
	    	@if($reservation->coupon->status == 'noValid')
      			@lang('app.novalidity_admin')
		    @elseif($reservation->coupon->status == 'Used')
		      <br> ** @lang('app.novalidity_client') **
		    @endif
		  </div>
		</div>
	</div>
</div>
<div class="modal-footer">
@if(!Auth::user()->hasRole('user'))
	@if($reservation->coupon->status == 'Valid' && (date('d-m-Y') == $reservation->coupon->validity) )
	<button type="button" data-id="{{ $reservation->coupon->id }}" data-num="{{ $reservation->num_reservation() }}" class="btn btn-success coupon-aplique">Aplicar descuento</button>
	@endif
@endif
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>