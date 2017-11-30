@extends('emails.layout')

@section('content')

<h1>{{ Settings::get('app_name') }}</h1>
<p>@lang('app.thank_you_for_registering', ['app' => Settings::get('app.name')])</p>

<p>@lang('app.confirm_pin')</p>

<p style="font-weight: bold; font-size: 16px;">PIN: {{ $pin }}</p>


@lang('app.many_thanks'), <br/>
{{ Settings::get('app_name') }}

@endsection