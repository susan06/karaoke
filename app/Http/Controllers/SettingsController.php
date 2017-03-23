<?php

namespace App\Http\Controllers;

use App\Events\Settings\Updated;
use Illuminate\Http\Request;
use Settings;
use Storage;
use DateTime;

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
     * Handle application settings update by ajax.
     *
     * @param Request $request
     * @return mixed
     */
    public function updateAjax(Request $request)
    {
        $this->updateSettings($request->all());
        $response = [
            'success' => true
        ];

        return response()->json($response);
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


    /**
     * store import by csv
     *
     * @param ImportSongRequest $request
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('image');
        $date = new DateTime();
    
        if($file){
            if ($file->isValid()) {
                $file_name = $date->getTimestamp().'.'.$file->getClientOriginalExtension();
                Storage::disk('login')->put($file_name, \File::get($file));

                return redirect()->back();

            } else {
                return redirect()->back()
                ->withErrors(trans('app.image_upload_success'));
            }
        }

        return redirect()->back()
                ->withErrors(trans('app.file_import_error'));
    }


}