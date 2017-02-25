<table class="table table-default">
        <thead>
        <tr>
            <th>@lang('app.song')</th>
            <th>@lang('app.artist')</th>
            <th>@lang('app.action')</th>
        </tr>
        </thead>
        <tbody class="songs" id="result_search">
        @if (count($songs))
            @foreach ($songs as $playlist) 
                <tr>
                    <td>{{$playlist->title}}</td>
                    <td>{{$playlist->artist}}</td>
                    <td>
                        <a class="btn btn-lg btn-sm btn-xs btn-success btn-apply-for" 
                        data-id="{{$playlist->song_id}}"
                        data-ref="{{route('song.apply.for', $playlist->id)}}"
                        data-confirm-title="@lang('app.please_confirm')"
                        data-confirm-text="@lang('app.are_you_sure_apply_song') la canción {{$playlist->title}} de {{$playlist->artist}}"
                        data-confirm="@lang('app.apply_for')">
                        @lang('app.apply_for')</a>    
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
<!--</div>-->  
@if (count($songs))
{!! $songs->links() !!}
@endif