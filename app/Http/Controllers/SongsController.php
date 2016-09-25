<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SongsController extends Controller
{
     /**
     * Search simple songs
     *
     * @return \Illuminate\View\View
     */
    public function search()
    {
        return view('songs.search');
    }

    /**
     * User´s List songs
     *
     * @return \Illuminate\View\View
     */
    public function searchAdvanced()
    {
        return view('songs.search_advanced');
    }


    /**
     * User´s List songs
     *
     * @return \Illuminate\View\View
     */
    public function myList()
    {
        return view('songs.my_list');
    }

    /**
     * User´s List songs
     *
     * @return \Illuminate\View\View
     */
    public function ranking()
    {
        return view('songs.ranking');
    }

}
