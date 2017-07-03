<div class="row">    
  <div class="col-lg-12 col-sm-12 col-xs-12">
      <div class="table-responsive">
         <table class="table table-default">
              <thead>
              <tr>
                  <th># Reserva</th>
                  <th>@lang('app.table')</th>
                  <th>@lang('app.date')</th>
                  <th>@lang('app.hour')</th>
                  @if (Auth::user()->hasRole('admin'))
                  <th>Sucursal</th> 
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
                          <td>{{ $reservation->num_reservation() }}</td>
                          <td>{{$reservation->num_table}}</td>
                          <td>{{date_format(date_create($reservation->date), 'd-m-Y')}}</td>
                          <td>{{$reservation->time}}</td>
                          @if (Auth::user()->hasRole('admin')) 
                          <td>
                             {{$reservation->branchoffice->name}} 
                          </td>
                          <td>
                               <a style="cursor:pointer;" tabindex="0" role="button" 
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
                            <input type="hidden" id="input_status_{{$reservation->id}}" value="{{ $reservation->nextStatus() }}"/>
                          <td id="status_{{$reservation->id}}">
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
                          @elseif (Auth::user()->hasRole('user'))
                              En proceso...
                          @endif
                          </td>                          
                          <td>
    
                         <button class="btn btn-lg btn-sm btn-xs btn-success create-edit-show {{ ($reservation->groupfie) ? 'block' : 'hide' }}" 
                            data-id="{{$reservation->id}}" title="Ver GROUPFIE - Cupón" data-title="Ver GROUPFIE - Cupón (Reservación # {{ $reservation->num_reservation() }})" data-href="{{ route('reservation.groupfie.show', $reservation->id) }}" data-model="modal" data-toggle="tooltip" data-placement="top" id="show-groupfie-{{$reservation->id}}"> GROUPFIE / Cupón
                          </button>
                         
                          @if (Auth::user()->hasRole('user') && $reservation->status == 1 && (date('Y-m-d') == $reservation->date))
                            @if(!$reservation->arrival)
                              <button class="btn btn-lg btn-sm btn-xs btn-success btn-arrival" 
                                    data-id="{{$reservation->id}}" title="Confirmar llegada" data-toggle="tooltip" data-placement="top"> Llegué
                              </button>
                            @endif
                            <button class="btn btn-lg btn-sm btn-xs btn-success btn-upload-group {{ ($reservation->arrival && !$reservation->groupfie) ? 'block' : 'hide' }}" id="upload-group-{{$reservation->id}}"
                                    data-id="{{$reservation->id}}" title="Subir GROUPFIE" data-toggle="tooltip" data-placement="top"> Subir GROUPFIE
                            </button>
                          @endif
                          @if (Auth::user()->hasRole('admin'))
                              @if($reservation->status != 3 && !$reservation->arrival)
                                  <button class="btn btn-lg btn-sm btn-xs {{ $reservation->classBtnStatus() }} btn-status"
                                  data-id="{{$reservation->id}}" title="@lang('app.change_status')" data-toggle="tooltip" data-placement="top"> {{ $reservation->textBtnStatus() }}</button> 
                              @endif 
                          @endif
                          @if (Auth::user()->hasRole('user') && ($reservation->status == 0 || $reservation->status == 1))
                            @if(!$reservation->arrival && (date('Y-m-d') < $reservation->date))
                            <button class="btn btn-lg btn-sm btn-xs btn-warning btn-status-cancel" data-num="{{$reservation->num_reservation()}}" data-status="{{$reservation->status}}" id="cancel-{{$reservation->id}}"
                                  data-id="{{$reservation->id}}" title="Cancelar reserva" data-toggle="tooltip" data-placement="top"> Cancelar
                            </button>
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
                                  <i class="icon_close_alt2"></i>  Eliminar 
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