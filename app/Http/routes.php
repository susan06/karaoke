<?php

/**
 * Authentication
 */

Route::get('login', 'Auth\AuthController@getLoginFacebook');

Route::get('/panel', [
    'as' => 'get.panel',
    'uses' => 'Auth\AuthController@getLogin'
]);
Route::post('/panel', [
    'as' => 'post.panel',
    'uses' => 'Auth\AuthController@postLogin'
]);

Route::get('logout', [
    'as' => 'auth.logout',
    'uses' => 'Auth\AuthController@getLogout'
]);


Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');
Route::get('register/confirmation/{token}', [
    'as' => 'register.confirm-email',
    'uses' => 'Auth\AuthController@confirmEmail'
]);


Route::get('password/remind', 'Auth\PasswordController@forgotPassword');
Route::post('password/remind', 'Auth\PasswordController@sendPasswordReminder');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


/**
 * Two-Factor Authentication
 */

Route::get('auth/two-factor-authentication', [
    'as' => 'auth.token',
    'uses' => 'Auth\AuthController@getToken'
]);

Route::post('auth/two-factor-authentication', [
    'as' => 'auth.token.validate',
    'uses' => 'Auth\AuthController@postToken'
]);


/**
 * Social Facebook Login
 */
Route::get('auth/{provider}/login', [
    'as' => 'social.login',
    'uses' => 'Auth\SocialAuthController@redirectToProvider',
    'middleware' => 'social.login'
]);

Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

/**
 * Other
 */

Route::get('/', [
    'as' => 'dashboard',
    'uses' => 'DashboardController@index'
]);

/**
 * User Profile
 */

Route::get('profile', [
    'as' => 'profile',
    'uses' => 'ProfileController@index'
]);

Route::get('profile/activity', [
    'as' => 'profile.activity',
    'uses' => 'ProfileController@activity'
]);

Route::put('profile/details/update', [
    'as' => 'profile.update.details',
    'uses' => 'ProfileController@updateDetails'
]);

Route::post('profile/avatar/update', [
    'as' => 'profile.update.avatar',
    'uses' => 'ProfileController@updateAvatar'
]);

Route::post('profile/avatar/update/external', [
    'as' => 'profile.update.avatar-external',
    'uses' => 'ProfileController@updateAvatarExternal'
]);

Route::put('profile/login-details/update', [
    'as' => 'profile.update.login-details',
    'uses' => 'ProfileController@updateLoginDetails'
]);

Route::put('profile/social-networks/update', [
    'as' => 'profile.update.social-networks',
    'uses' => 'ProfileController@updateSocialNetworks'
]);

Route::post('profile/two-factor/enable', [
    'as' => 'profile.two-factor.enable',
    'uses' => 'ProfileController@enableTwoFactorAuth'
]);

Route::post('profile/two-factor/disable', [
    'as' => 'profile.two-factor.disable',
    'uses' => 'ProfileController@disableTwoFactorAuth'
]);

Route::get('profile/sessions', [
    'as' => 'profile.sessions',
    'uses' => 'ProfileController@sessions'
]);

Route::delete('profile/sessions/{session}/invalidate', [
    'as' => 'profile.sessions.invalidate',
    'uses' => 'ProfileController@invalidateSession'
]);

/**
 * User Management
 */
Route::get('user', [
    'as' => 'user.list',
    'uses' => 'UsersController@index'
]);

Route::get('user/create', [
    'as' => 'user.create',
    'uses' => 'UsersController@create'
]);

Route::post('user/create', [
    'as' => 'user.store',
    'uses' => 'UsersController@store'
]);

Route::get('user/{user}/show', [
    'as' => 'user.show',
    'uses' => 'UsersController@view'
]);

Route::get('user/{user}/edit', [
    'as' => 'user.edit',
    'uses' => 'UsersController@edit'
]);

Route::put('user/{user}/update/details', [
    'as' => 'user.update.details',
    'uses' => 'UsersController@updateDetails'
]);

Route::put('user/{user}/update/login-details', [
    'as' => 'user.update.login-details',
    'uses' => 'UsersController@updateLoginDetails'
]);

Route::delete('user/{user}/delete', [
    'as' => 'user.delete',
    'uses' => 'UsersController@delete'
]);

Route::post('user/{user}/update/avatar', [
    'as' => 'user.update.avatar',
    'uses' => 'UsersController@updateAvatar'
]);

Route::post('user/{user}/update/avatar/external', [
    'as' => 'user.update.avatar.external',
    'uses' => 'UsersController@updateAvatarExternal'
]);

Route::post('user/{user}/update/social-networks', [
    'as' => 'user.update.socials',
    'uses' => 'UsersController@updateSocialNetworks'
]);

Route::get('user/{user}/sessions', [
    'as' => 'user.sessions',
    'uses' => 'UsersController@sessions'
]);

Route::delete('user/{user}/sessions/{session}/invalidate', [
    'as' => 'user.sessions.invalidate',
    'uses' => 'UsersController@invalidateSession'
]);

Route::post('user/{user}/two-factor/enable', [
    'as' => 'user.two-factor.enable',
    'uses' => 'UsersController@enableTwoFactorAuth'
]);

Route::post('user/{user}/two-factor/disable', [
    'as' => 'user.two-factor.disable',
    'uses' => 'UsersController@disableTwoFactorAuth'
]);

/**
 * Roles & Permissions
 */

Route::get('role', [
    'as' => 'role.index',
    'uses' => 'RolesController@index'
]);

Route::get('role/create', [
    'as' => 'role.create',
    'uses' => 'RolesController@create'
]);

Route::post('role/store', [
    'as' => 'role.store',
    'uses' => 'RolesController@store'
]);

Route::get('role/{role}/edit', [
    'as' => 'role.edit',
    'uses' => 'RolesController@edit'
]);

Route::put('role/{role}/update', [
    'as' => 'role.update',
    'uses' => 'RolesController@update'
]);

Route::delete('role/{role}/delete', [
    'as' => 'role.delete',
    'uses' => 'RolesController@delete'
]);


/**
 * Activity Log
 */

Route::get('activity', [
    'as' => 'activity.index',
    'uses' => 'ActivityController@index'
]);

Route::get('activity/user/{user}/log', [
    'as' => 'activity.user',
    'uses' => 'ActivityController@userActivity'
]);

/**
 * Songs
 */

Route::get('songs/search', [
    'as' => 'song.search',
    'uses' => 'SongsController@search'
]);

Route::get('songs/search/advanced', [
    'as' => 'song.search.advanced',
    'uses' => 'SongsController@searchAdvanced'
]);

Route::get('my_songs', [
    'as' => 'song.my_list',
    'uses' => 'SongsController@myList'
]);

Route::get('songs/ranking', [
    'as' => 'song.ranking',
    'uses' => 'SongsController@ranking'
]);

