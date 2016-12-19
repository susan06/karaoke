@extends('layouts.app')

@section('page-title', trans('app.branch_offices'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_genius"></i> 
              {{ trans('app.branch_office').' '.$branch_office->name }}
            </h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   {{ $branch_office->name }}
                </header>
                <div class="panel-body">

                    <div class="form form-validate form-horizontal">
                          <div class="form-group">
                              <label class="control-label col-lg-2">@lang('app.name')</label>
                              <div class="col-lg-6">
                                  {{ $branch_office->name }}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">@lang('app.email_request_song')</label>
                              <div class="col-lg-6">
                               {{ $branch_office->email_song }}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">@lang('app.email_request_reservations')</label>
                              <div class="col-lg-6">
                                {{ $branch_office->email_reservations }}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Latitud</label>
                              <div class="col-lg-6">
                                 {{ $branch_office->lat }}
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="control-label col-lg-2">Logintud</label>
                              <div class="col-lg-6">
                                 {{ $branch_office->lng }}
                              </div>
                          </div>

                           <div class="form-group">
                              <label class="control-label col-lg-2">Estatus</label>
                              <div class="col-lg-6">
                                  <span class="label label-{{ $branch_office->labelClass() }}">{{ trans("app.{$branch_office->textStatus()}") }}</span>
                              </div>
                          </div>

                          <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <a href="{{ route('branch-office.edit', $branch_office->id ) }}" class="btn btn-primary" type="button">
                                  @lang('app.edit')
                                </a>
                                <a href="{{ route('branch-office.index') }}" class="btn btn-default" type="button">
                                  @lang('app.back')
                                </a>
                            </div>
                          </div>
                    </div>
 
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->
@stop


