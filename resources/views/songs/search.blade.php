@extends('layouts.app')

@section('page-title', trans('app.songs'))

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-play-circle"></i> @lang('app.ask_song')</h3>
        </div>
    </div>

  <!-- page start-->
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">

            <section class="panel">
               <header class="panel-heading">
                   @lang('app.search')
                </header>
                <div class="panel-body">
                    <div class="row">    
                        <div class="col-lg-7 col-sm-8 col-xs-12 margen_search">
                            <div class="input-group">         
                                <input type="text" class="form-control" name="q" id="search" placeholder="@lang('app.search_song_artist')">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-search" type="button"><span class="fa fa-search"></span></button>
                                    <button class="btn btn-danger" type="button" id="reset_search"><span class="icon_close_alt2"></span></button>
                                </span>
                            </div>
                        </div>
                  </div> 
                  <div class="row">    
                        <div class="col-lg-10 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                               <table class="table">
                                    <thead>
                                    <tr>
                                        <th>@lang('app.song')</th>
                                        <th>@lang('app.artist')</th>
                                        <th>@lang('app.action')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="result_search">
                                    <tr>
                                        <td colspan="3"><em>@lang('app.first_search')</em></td>
                                    </tr>                             
                                    </tbody>
                               </table>
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

var first_search = '@lang("app.first_search")';

$(document).ready(function(e){

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    })

    $('#search').autoComplete({
        minChars: 2,
        source: function(term, response){
            term = term.toLowerCase();
            $.getJSON('{{route("song.search.ajax")}}', 
                { q: term }, 
                function(data){ response(data);
            });
        }
    })

    $('#search').keyup(function(e) {
        $(".autocomplete-suggestions").hide();
        var unicode = e.keyCode ? e.keyCode : e.which;    
        console.log(unicode);
        if (unicode == 13){  
           start_search();
        }    
    })

    $('.btn-search').click(function() {
        $(".autocomplete-suggestions").hide();
        start_search();
    })

    $('#reset_search').click(function() {
        document.getElementById('search').value = '';
        reset_search();
    })

});

    function reset_search() {
        document.getElementById('result_search').innerHTML = '';
        var tr = document.createElement('TR');
        var td = document.createElement('TD');
        var em = document.createElement('em');
        td.setAttribute("colspan", 3);
        var t = document.createTextNode(first_search);
        em.appendChild(t);
        td.appendChild(em);
        tr.appendChild(td);
        container = document.getElementById('result_search');
        container.appendChild(tr);
    }

    function apply_for() {
        $('.btn-apply-for').click(function() {
            var $this = $(this);
            var row = $this.closest('tr');
            swal({   
                title: $this.data('confirm-title'),   
                text: $this.data('confirm-text'),   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: $this.data('confirm'),   
                closeOnConfirm: false }, 
                function(isConfirm){   
                    if (isConfirm) {  
                        // code apply for
                        swal("@lang('app.info')", "@lang('app.apply_for_send')", "success");     
                    } 
            })
        })
    }

    function construct_result(songs) {
        document.getElementById('result_search').innerHTML = '';
        $.each(songs.data, function(i, item){
            var tr = document.createElement('TR');

            var td = document.createElement('TD');
            var td1 = document.createElement('TD');
            var td2 = document.createElement('TD');

            var apply_for = document.createTextNode("@lang('app.apply_for')");
            var title = document.createTextNode(item.title);
            var artist = document.createTextNode(item.artist);

            btn = document.createElement('a');
            btn.className = 'btn btn-success btn-apply-for';
            btn.setAttribute("data-id", item.id);
            btn.setAttribute("data-confirm-title", "@lang('app.please_confirm')");
            btn.setAttribute("data-confirm-text", "@lang('app.are_you_sure_apply_song') la canción"+item.title+' de '+item.artist);
            btn.setAttribute("data-confirm", "@lang('app.apply_for')");

            btn.appendChild(apply_for);
            td.appendChild(title);
            td1.appendChild(artist);
            td2.appendChild(btn);
            tr.appendChild(td);
            tr.appendChild(td1);
            tr.appendChild(td2);

            container = document.getElementById('result_search');
            container.appendChild(tr);
        })
        apply_for();
    }

    function start_search() {
        if ($('#search').val()) {  
            $.ajax({
                type: 'POST',
                url: '{{route("song.search.ajax.client")}}',
                dataType: 'json',
                data: { 'q': $('#search').val() },
                success: function (songs) {                           
                    construct_result(songs);
                },
                error: function () {
                   //
                }
            })     
        } 
    }

</script>

@stop
