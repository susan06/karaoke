@extends('layouts.app')

@section('page-title', trans('app.events'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_genius"></i> 
                {{  trans('app.event').' '.$event->name }}
            </h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.form')
                </header>
                <div class="panel-body">
                    {!! Form::open(['route' => ['event.store.client', $event->id], 'autocomplete' => 'off', 'id' => 'event-form','class'=>'form-validate form-horizontal']) !!}
                    <div class="form">
                         <div class="form-group">
                            <label class="control-label col-lg-2">@lang('app.clients')</label>
                            <div class="col-lg-6">
                           
                              <select name="user_id" class="form-control">
                               @foreach($list_clients as $client)
                                <option value="{{$client->id}}">{{$client->first_name.' '.$client->last_name.' - '.$client->username}}</option>
                                @endforeach
                              </select>
                            
                            </div>

                            <div class="col-lg-4">
                              <button class="btn btn-primary" type="submit">
                                @lang('app.add')
                              </button>
                          </div>

                        </div>
                    </div>

                {!! Form::close() !!}
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->
@stop
