<?php

namespace App\Http\Controllers;

use App\Events\Settings\Updated;
use Illuminate\Http\Request;
use Settings;

/**
 * Class SettingsController
 * @package App\Http\Controllers
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
     * Display general settings background.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function background()
    {
        return view('settings.background');
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

        event(new Updated);

    }


}