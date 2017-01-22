<table class="table table-default">
   <thead>
      <tr>
          <th>@lang('app.client')</th>
          <th>@lang('app.total_votes')</th>
      </tr>
      </thead>
      <tbody>
        @if (count($votes) > 0)
            @foreach ($votes as $vote => $value) 
                <tr>
                    <td>{!! $value['participant'] !!}</td>
                    <td>{{ $value['count'] }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2"><em>@lang('app.no_records_found')</em></td>
            </tr>
        @endif
      </tbody>
 </table>