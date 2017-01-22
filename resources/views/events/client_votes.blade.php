@extends('layouts.app')

@section('page-title', trans('app.events'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="icon_genius"></i> 
                {{  trans('app.contest').': '.$event->name.' - '.trans('app.branch_office').' '.$event->branch_office->name }}
            </h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   @lang('app.votes_clients')
                </header>
                <div class="panel-body">

                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="row">
                     <div id="reload_list">
                      @include('events.list_votes')
                     </div>
                    </div>
                  </div>
                </div>
            </section>
        </div>
    </div>
  <!-- page end-->
@stop

@section('scripts')
<script type="text/javascript">
       function reload_votes() {
        console.log('{{ route("event.show.votes", $event->id) }}');
            $.ajax({
                url: '{{ route("event.show.votes", $event->id) }}',
                type : 'get',
                dataType: 'json',
                success: function (response) {
                  if(response.success){
                    $('#reload_list').html(response.view);
                  }
                }
            });
        }
    
        $(document).ready(function () {            
            setInterval(reload_votes,5000);
        });

</script>
@endsection