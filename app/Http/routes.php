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

Route::put('user/{user}/update/details/by/admin', [
    'as' => 'user.admin.update.details',
    'uses' => 'UsersController@updateDetailsByAdmin'
]);

Route::put('user/{user}/update/login-details', [
    'as' => 'user.update.login-details',
    'uses' => 'UsersController@updateLoginDetails'
]);

Route::post('user/delete', [
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

Route::get('user/{user}/sessions', [
    'as' => 'user.sessions',
    'uses' => 'UsersController@sessions'
]);

Route::delete('user/{user}/sessions/{session}/invalidate', [
    'as' => 'user.sessions.invalidate',
    'uses' => 'UsersController@invalidateSession'
]);

/**
 * User Client Management
 */
Route::get('clients', [
    'as' => 'user.client.index',
    'uses' => 'ClientsController@index'
]);

Route::get('client/{user}/show', [
    'as' => 'user.client.show',
    'uses' => 'ClientsController@view'
]);

Route::get('activity/client/{user}/log', [
    'as' => 'activity.user.client',
    'uses' => 'ClientsController@activity'
]);

Route::get('client/{user}/sessions', [
    'as' => 'user.client.sessions',
    'uses' => 'ClientsController@sessions'
]);

Route::delete('client/{user}/sessions/{session}/invalidate', [
    'as' => 'user.client.sessions.invalidate',
    'uses' => 'ClientsController@invalidateSession'
]);

Route::get('search/clients', [
    'as' => 'find.clients',
    'uses' => 'ClientsController@get_clients'
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
 * Settings
 */
Route::group([
     'prefix' => 'settings',
 ], function () {
    
    Route::get('/general',
        'SettingsController@general')
        ->name('settings.general');

    Route::get('/background',
        'SettingsController@background')
        ->name('settings.background');

    Route::post('/update',
        'SettingsController@update')
        ->name('settings.update');

    Route::post('/update/ajax',
        'SettingsController@updateAjax')
        ->name('settings.update.ajax');

    Route::post('/upload/image',
        'SettingsController@uploadImage')
        ->name('image.upload');    
});


/**
 * Songs
 */
Route::group([
     'prefix' => 'songs',
 ], function () {

    Route::get('/all',
        'SongsController@index')
        ->name('song.index');

    Route::get('/create',
        'SongsController@create')
        ->name('song.create');

    Route::post('/store',
        'SongsController@store')
        ->name('song.store');

    Route::get('/import',
        'SongsController@import')
        ->name('song.import');

    Route::post('/import/store',
        'SongsController@storeImport')
        ->name('song.import.store');

    Route::get('/search',
        'SongsController@search')
        ->name('song.search');

    Route::get('/search/ajax/by/client',
        'SongsController@searchByClient')
        ->name('song.search.ajax.client');

    Route::get('/ajax/search',
        'SongsController@searchAutocomplete')
        ->name('song.search.ajax');

    Route::get('/artist/ajax/search',
        'SongsController@searchArtistAjax')
        ->name('song.artist.search.ajax');

    Route::get('/apply/for',
        'SongsController@applySong')
        ->name('song.apply.for');

    Route::get('/my_list',
        'SongsController@myList')
        ->name('song.my_list');

    Route::get('/ranking',
        'SongsController@ranking')
        ->name('song.ranking');

    Route::get('/apply/actuality',
        'SongsController@applyActuality')
        ->name('song.apply.list');

    Route::get('/play',
        'SongsController@playSong')
        ->name('song.dj.play');
});

/*
 * Reservations
*/

Route::get('reservations',
    'ReservationsController@index')
    ->name('reservation.index');

Route::get('reservations/clients',
    'ReservationsController@adminIndex')
    ->name('reservation.adminIndex');

Route::get('reservations/store',
    'ReservationsController@clientStore')
    ->name('reservation.clientStore');

Route::post('reservations/status/update',
    'ReservationsController@updateStatus')
    ->name('reservation.status.update');

Route::post('reservations/by/client/ajax',
    'ReservationsController@reserveByClient')
    ->name('reservation.client.ajax');

Route::post('reservations/delete', [
    'as' => 'reservation.delete',
    'uses' => 'ReservationsController@delete'
]);

/* Branch Offices Adminitration */
Route::resource('branch-office', 'BranchOfficeController');

/* Events  */

Route::get('event/add/client/{id}',
    'EventController@add_client')
    ->name('event.add.client');
    
Route::post('event/store/client/{id}', [
    'as' => 'event.store.client',
    'uses' => 'EventController@storeClient'
]);

Route::get('event/show/votes/{id}',
    'EventController@show_votes')
    ->name('event.show.votes');

Route::get('contests',
    'EventController@contests')
    ->name('event.contests');

Route::get('contests/show/participants/{id}',
    'EventController@show_participants')
    ->name('event.show.participants');

Route::get('event/vote/participants', [
    'as' => 'event.vote.participants',
    'uses' => 'EventController@vote_participant'
]);

Route::post('event/delete', [
    'as' => 'event.delete',
    'uses' => 'EventController@delete'
]);

Route::post('event/delete/participant', [
    'as' => 'event.delete.participant',
    'uses' => 'EventController@delete_participant'
]);

Route::resource('event', 'EventController');