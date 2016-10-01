<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;
use App\Events\Song\Created;
use App\Events\Song\Imported;
use App\Repositories\Song\SongRepository;
use App\Http\Requests\Song\CreateSongRequest;
use App\Http\Requests\Song\ImportSongRequest;

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
        return view('songs.create');
    }

    /**
     *create song
     *
     * @param CreateUserRequest $request
     */
    public function store(CreateSongRequest $request)
    {
        $song = $this->songs->create($request->all());

        event(new Created($song));

        return redirect()->route('song.index')
            ->withSuccess(trans('app.song_created'));
    }

    /**
     * import song
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('songs.import_csv');
    }

    /**
     * store import by csv
     *
     * @param ImportSongRequest $request
     */
    public function storeImport(ImportSongRequest $request)
    {
        $file = $request->file('csv_import');
        $file_name = 'list_song.csv';
        $path = storage_path('app/song');
        if($file){
            if ($file->isValid()) {
                Storage::disk('song')->put($file_name, $file);
                $contents = Storage::disk('song')->get($file_name);
                /*
                Excel::filter('chunk')->load($contents)->chunk(250, function($results)
                {
                        foreach($results as $row)
                        {
                            $this->songs->create([
                                'artist' => $row->artist, 
                                'title' => $row->title
                            ]);
                        }
                })*/
            } else {
                return redirect()->back()
                ->withErrors(trans('app.file_import_error'));
            }
        }

        event(new Imported);

        return redirect()->route('song.index')
            ->withSuccess(trans('app.song_import_store'));
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
     * Search simple artist autocomplete
     *
     * @return \Illuminate\View\View
     */
    public function searchArtistAjax(Request $request)
    {
        $term = $request->artist;
        $artist = $this->songs->autocompleteArtist($term);

        return response()->json($artist); 
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
