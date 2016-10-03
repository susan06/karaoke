<p>@lang('app.hi') {{ $user->present()->nameOrEmail }},</p>

<p>@lang('app.new_user_was_registered_on', ['app' => Settings::get('app_name')])</p>

<p>@lang('app.to_view_details_visit_link_below')</p>

<p><a href="{{ route('user.show', $newUser->id) }}">{{ route('user.show', $newUser->id) }}</a></p>

@lang('app.many_thanks'), <br/>
{{ Settings::get('app_name') }}