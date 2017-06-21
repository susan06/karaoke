@extends('layouts.app')

@section('page-title', trans('app.branch_offices'))

@section('content')

    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <h3 class="page-header"><i class="icon_genius"></i> @lang('app.branch_offices')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
                <header class="panel-heading">
                   @lang('app.list_of_registered_branch_offices')
                </header>
                <div class="panel-body">

                    <form method="GET" action="" accept-charset="UTF-8" id="branch-offices-form">
                      <div class="form-group">
                          <div class="col-lg-10 col-sm-12 col-xs-12">
                              <div class="row">
                                  <div class="col-lg-4 col-sm-4 col-xs-5 margin_search">
                                      {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
                                  </div>

                                  <div class="col-lg-6 col-sm-6 col-xs-7 margin_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_branch')">
                                        
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
                                             @if (Input::has('search') && Input::get('search') != '')
                                              <a href="{{ route('branch-office.index') }}" class="btn btn-danger">
                                                 <i class="icon_close_alt2"></i>
                                              </a>
                                             @endif
                                        </span>
                                    </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                    </form>
                     <div class="col-md-2 pull-right">
                       <a href="{{ route('branch-office.create') }}" class="btn btn-primary" id="add-branch-office">
                          <i class="fa fa-plus"></i>
                          @lang('app.add_branch_office')
                      </a>
                      </div>
 
                       <table class="table table-default">
                            <thead>
                            <tr>
                                <th>@lang('app.name')</th>
                                <th>@lang('app.registration_date')</th>
                                <th>@lang('app.status')</th>
                                <th class="text-center">@lang('app.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($branch_offices))
                                @foreach ($branch_offices as $branch_office) 
                                    <tr>
                                        <td>{{ $branch_office->name }}</td>
                                        <td>{{ $branch_office->created_at }}</td>
                                        <td>
                                            <span class="label label-{{ $branch_office->labelClass() }}">{{ trans("app.{$branch_office->textStatus()}") }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('branch-office.show', $branch_office->id) }}" class="btn btn-success btn-sm btn-xs"
                                               title="@lang('app.view_branch_office')" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('branch-office.edit', $branch_office->id) }}" class="btn btn-warning btn-sm btn-xs edit" title="@lang('app.edit_branch_office')"
                                                  data-toggle="tooltip" data-placement="top">
                                              <i class="fa fa-pencil"></i>
                                            </a>
                                             <a href="javascript:void(0)" class="btn btn-sm btn-xs btn-danger btn-delete" title="@lang('app.delete_branch')"
                                                    data-href="{{ route('branch-office.delete', $branch_office->id) }}"
                                                    data-id="{{$branch_office->id}}"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    data-confirm-title="@lang('app.please_confirm')"
                                                    data-confirm-text="@lang('app.are_you_sure_delete_branch')"
                                                    data-confirm-delete="@lang('app.yes_delete_him')">
                                                <i class="icon_close_alt2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                                </tr>
                            @endif                                                       
                            </tbody>
                       </table>
               
                   {!! $branch_offices->render() !!}
                </div>
            </section>

        </div>
    </div>
  <!-- page end-->
@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#branch-offices-form").submit();
        });
    </script>
@stop
