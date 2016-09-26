<?php

namespace App\Http\Controllers;

use App\Http\Request;

/**
 * Class SettingsController
 * @package Vanguard\Http\Controllers
 */
class SettingsController extends Controller
{
    /**
     * Display general settings page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function general()
    {
        return view('settings.general');
    }

    /**
     * Handle application settings update.
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $this->updateSettings($request->except("_token"));

        return back()->withSuccess(trans('app.settings_updated'));
    }

    /**
     * Update settings and fire appropriate event.
     *
     * @param $input
     */
    private function updateSettings($input)
    {
        foreach($input as $key => $value) {
            Settings::set($key, $value);
        }

        Settings::save();

        event(new SettingsUpdated);
    }


}