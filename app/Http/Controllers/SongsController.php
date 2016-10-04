<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use Auth;
use App\User;
use App\Song;
use App\Playlist;
use App\Http\Requests;
use App\Mailers\NotificationMailer;
use App\Events\Song\Created;
use App\Events\Song\Imported;
use App\Repositories\Song\SongRepository;
use App\Repositories\Playlist\PlaylistRepository;
use App\Http\Requests\Song\CreateSongRequest;
use App\Http\Requests\Song\ImportSongRequest;

class SongsController extends Controller
{
    /**
     * @var SongRepository
     */
    private $songs;

    /**
     * @var PlaylistRepository
     */
    private $playlists;

    /**
     * SongsController constructor.
     * @param SongRepository $songs
     */
    public function __construct(SongRepository $songs, PlaylistRepository $playlists)
    {
        $this->middleware('auth');
        $this->songs = $songs;
        $this->playlists = $playlists;
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
        $canCreate = $this->songs->canAdd($request->all());

        if( $canCreate['success'] ) {
            $song = $this->songs->create($request->all());
            event(new Created($song));

            return redirect()->route('song.index')
                ->withSuccess(trans('app.song_created'));
        }

        $song = $canCreate['song'];

        return redirect()->route('song.index','q='.$song['artist'].' - '.$song['title'])
            ->withWarning(trans('app.song_exist'));
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
        $file_name = 'list_songs.csv';
        $path = public_path().'/upload/song/';
        if($file){
            if ($file->isValid()) {
                Storage::disk('song')->put($file_name, \File::get($file));

                Excel::filter('chunk')->load($path.$file_name)->chunk(100, function($results)
                {
                    foreach($results as $row)
                    {
                        if( $row->artist && $row->title) {
                            $data = [
                                'artist' => $row->artist, 
                                'title' => $row->title
                            ];
                            $canCreate = $this->songs->canAdd($data);
                            if( $canCreate['success'] ) {
                                $song = $this->songs->create($data);
                            }
                        }
                    }
                });

                event(new Imported);

                return redirect()->route('song.index')
                    ->withSuccess(trans('app.song_import_store'));

            } else {
                return redirect()->back()
                ->withErrors(trans('app.file_import_error'));
            }
        }

        return redirect()->back()
                ->withErrors(trans('app.file_import_error'));
    }

    /**
     * Search simple songs autocomplete
     *
     * @return \Illuminate\View\View
     */
    public function searchAutocomplete(Request $request)
    {
        $term = $request->q;
        $songs = $this->songs->autocomplete($term);

        return response()->json($songs); 
    }

    /**
     * Search songs by clients
     *
     * @return \Illuminate\View\View
     */
    public function searchByClient(Request $request)
    {
        $perPage = 10;
        $search = $request->q;
        $songs = $this->songs->search($perPage, $search);
        
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
    public function myList(Request $request)
    {
        $perPage = 10;
        if($request->user) {
            $user_id = $request->user;
            $user = User::find($user_id);
            $admin = true;
        } else {
            $user_id = Auth::id();
            $admin = false;
            $user = false;
        }
        
        $songs = $this->playlists->myList($perPage, $request->search, $user_id, $admin);

        return view('songs.my_list', compact('songs', 'admin', 'user'));
    }

    /**
     * Ranking top 50
     *
     * @return \Illuminate\View\View
     */
    public function ranking(Request $request)
    {
        $perPage = 10;
        $i = 1;
        $songs = $this->playlists->ranking($perPage, $request->search);

        return view('songs.ranking', compact('songs', 'i'));
    }

    /**
     * Apply song filter by date
     *
     * @return \Illuminate\View\View
     */
    public function applyActuality(Request $request)
    {
        $perPage = 20;
        $songs = $this->playlists->listActuality($perPage, $request->date);

        return view('songs.actuality', compact('songs'));
    }

    /**
     * Apply for song
     *
     * @param Song $song
     */
    public function applySong(Request $request, NotificationMailer $mailer)
    {
        try {
            $this->playlists->create(['song_id' => $request->id, 'user_id' => Auth::id()]);
            $song = $this->songs->find($request->id); 
            //$mailer->sendApplySong($song, Auth::user());
            $response = [
                'success' => true,
                'status' => 'success',
                'disabled' => true,
                'message' => trans('app.apply_for_send')
            ];
        } catch (Exception $e){
            $response = [
                'success' => false,
                'status' => 'error',
                'disabled' => false,
                'message' => trans('app.apply_for_send_not')
            ];
        }
            
        return response()->json($response);
        
    }

    /**
     * play song by dj
     *
     * @param Song $song
     */
    public function playSong(Request $request)
    {
        try {
            $this->playlists->update($request->id, ['play_status' => true]);
            $response = [
                'success' => true,
                'status' => 'success'
            ];
        } catch (Exception $e){
            $response = [
                'success' => false,
                'status' => 'error'
            ];
        }
            
        return response()->json($response);
        
    }

}
