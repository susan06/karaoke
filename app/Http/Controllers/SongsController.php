<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\Song\SongRepository;

class SongsController extends Controller
{
    /**
     * @var SongRepository
     */
    private $songs;

    /**
     * SongsController constructor.
     * @param SongRepository $songs
     */
    public function __construct(SongRepository $songs)
    {
        $this->middleware('auth');
        $this->songs = $songs;
    }


    /**
     * List all songs
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $perPage = 10;
        $songs = $this->songs->index($perPage, $request->q);

        return view('songs.index', compact('songs'));
    }

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
     *create song
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('songs.search');
    }

    /**
     * import song
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('songs.search');
    }

    /**
     * Search simple songs autocomplete
     *
     * @return \Illuminate\View\View
     */
    public function searchAjax(Request $request)
    {
        $term = $request->q;

        $songs = $this->songs->autocomplete($term);

        return response()->json($songs); 

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
